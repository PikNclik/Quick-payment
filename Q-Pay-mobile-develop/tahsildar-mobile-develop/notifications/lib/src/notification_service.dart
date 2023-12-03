import 'dart:async';
import 'dart:convert';
import 'dart:io';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart';

import 'firebase_options.dart';

/// Define and initialize FirebaseMessaging globally
FirebaseMessaging firebaseMessaging = FirebaseMessaging.instance;

/// define FlutterLocalNotificationsPlugin globally
final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin = FlutterLocalNotificationsPlugin();

/// Create a [AndroidNotificationChannel] for heads up notifications
late AndroidNotificationChannel channel;

/// android channel id, ex: "package name"
String _androidChannelId = 'androidChannelId';

/// android channel name, ex: "app name"
String _androidChannelName = 'androidChannelName';

/// notification primary color
Color _color = Colors.grey;

class NotificationService {
  static bool listened = false;
  static bool isFlutterLocalNotificationsInitialized = false;

  /// callback for select notification in foreground/background
  final bool Function(String? payload) onSelectNotification;

  /// notification icon
  final String notificationIcon;

  /// ios native notification channel method, ex: "com.tradinos/notifications"
  final String? iosChannelMethod;

  NotificationService({
    required this.onSelectNotification,
    required String androidChannelId,
    required String androidChannelName,
    required Color color,
    required this.notificationIcon,
    this.iosChannelMethod,
  }) {
    _androidChannelId = androidChannelId;
    _androidChannelName = androidChannelName;
    _color = color;
  }

  Future<void> initializeNotificationService() async {
    /// 1. initialize Firebase
    await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);

    await _setupLocalNotifications();
    await _setupPushNotifications();
  }

  /// setup local-notificiation configuration
  Future<void> _setupLocalNotifications() async {
    if (isFlutterLocalNotificationsInitialized) return;

    /// 2. set the AndroidInitializationSettings
    AndroidInitializationSettings androidInitializationSettings = AndroidInitializationSettings(notificationIcon);

    /// 3. Requests the `POST_NOTIFICATIONS` permission on Android 13 Tiramisu (API level 33) and newer.
    flutterLocalNotificationsPlugin.resolvePlatformSpecificImplementation<AndroidFlutterLocalNotificationsPlugin>()?.requestPermission();

    /// Create an Android Notification Channel.
    channel = AndroidNotificationChannel(
      _androidChannelId, // id
      _androidChannelName, // title
      description: 'This channel is used for important notifications.', // description
      importance: Importance.high,
    );

    /// We use this channel in the `AndroidManifest.xml` file to override the
    /// default FCM channel to enable heads up notifications.
    await flutterLocalNotificationsPlugin.resolvePlatformSpecificImplementation<AndroidFlutterLocalNotificationsPlugin>()?.createNotificationChannel(channel);

    /// 5. set the IOSInitializationSettings
    final DarwinInitializationSettings iosInitializationSettings = DarwinInitializationSettings(
      requestSoundPermission: true,
      requestBadgePermission: true,
      requestAlertPermission: true,
      onDidReceiveLocalNotification: null,
    );

    /// 5. set the InitializationSettings
    /// [which binds AndroidInitializationSettings and IOSInitializationSettings]
    InitializationSettings initializationSettings = InitializationSettings(
      android: androidInitializationSettings,
      iOS: iosInitializationSettings,
    );

    /// 6. initialize FlutterLocalNotificationsPlugin
    await flutterLocalNotificationsPlugin.initialize(
      initializationSettings,
      onDidReceiveNotificationResponse: (details) {
        onSelectNotification.call(details.payload);
      },
    );

    isFlutterLocalNotificationsInitialized = true;
  }

  /// setup notificiation-handling configuration
  Future<void> _setupPushNotifications() async {
    // request permission for receiving notifications if the device platform is iOS
    await _iosNotificationPermission();

    // handling foreground notifications
    await _handlingForegroundNotifications();

    // handling background notifications
    await _handlingBackgroundNotifications();

    // handling ios background notifications
    if (Platform.isIOS) await _setupiOSMethodNative();
  }

  /// a function to request ios permission for receiving notifications
  Future<void> _iosNotificationPermission() async {
    if (Platform.isIOS) {
      NotificationSettings settings = await firebaseMessaging.requestPermission(
        alert: true,
        announcement: false,
        badge: true,
        carPlay: false,
        criticalAlert: false,
        provisional: false,
        sound: true,
      );

      if (kDebugMode) print('User granted permission: ${settings.authorizationStatus}');
    }
  }

  /// handling foreground notifications
  Future<void> _handlingForegroundNotifications() async {
    if (!listened) {
      /// 1. setting foreground notifications
      await firebaseMessaging.setForegroundNotificationPresentationOptions(alert: true, badge: true, sound: true);

      /// 2. listening to foreground notifications
      FirebaseMessaging.onMessage.listen(displayNotification);
      listened = true;
    }
  }

  /// handling background notifications
  Future<void> _handlingBackgroundNotifications() async {
    // There are a few things to keep in mind about your background message handler:
    // It must not be an anonymous function.
    // It must be a top-level function (e.g. not a class method which requires initialization)
    FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);
  }

  /// Setup iOS when click on a notification, or when present a new notification
  Future<void> _setupiOSMethodNative() async {
    if (iosChannelMethod == null) return;
    final platform = MethodChannel(iosChannelMethod.toString());
    // Setup when click on a notification
    platform.setMethodCallHandler((call) {
      Map<String, dynamic> map = Map<String, dynamic>.from(call.arguments);
      if (map["payload"] == null) map["payload"] = map;
      //------------ handle notification on click
      if (call.method == "didReceive") {
        final payload = jsonEncode(map);
        onSelectNotification(payload);
      }
      return call.arguments;
    });
  }

  /// cancel all notifications
  Future<void> cancelAll() async {
    await flutterLocalNotificationsPlugin.cancelAll();
  }

  /// debug for notifications payload when you cannot print in console.
  static debug(String? message) {
    if (kDebugMode) {
      Fluttertoast.showToast(msg: message ?? "debugging on null value");
    }
  }

  /// get fcm token
  Future<String?> getMessagingToken() async {
    final complete = Completer<String?>();
    firebaseMessaging.getToken().then((value) => complete.complete(value));
    return complete.future;
  }
}

/// a function to display notifications for android, iOS will show notification automatically
void displayNotification(RemoteMessage message) async {
  if (Platform.isAndroid) {
    ByteArrayAndroidBitmap? bigPicture;
    try {
      bigPicture = ByteArrayAndroidBitmap(await _getByteArrayFromUrl(message.data["image"]));
    } catch (_) {
      // in case notification image is empty or can't be loaded
    }

    final androidNotificationDetails = AndroidNotificationDetails(
      channel.id,
      channel.name,
      channelDescription: channel.description,
      color: _color,
      largeIcon: bigPicture,
      priority: Priority.max,
      styleInformation: const BigTextStyleInformation(
        '',
        htmlFormatBigText: true,
        htmlFormatContent: true,
        htmlFormatContentTitle: true,
        htmlFormatSummaryText: true,
      ),
    );

    flutterLocalNotificationsPlugin.show(
      message.hashCode,
      message.data["title"],
      message.data["body"],
      NotificationDetails(android: androidNotificationDetails),
      payload: jsonEncode(message.data), // this payload will be sent to selectNotification
    );
  }
}

/// load image from url
Future<Uint8List> _getByteArrayFromUrl(String url) async {
  final Response response = await get(Uri.parse(url));
  return response.bodyBytes;
}

@pragma("vm:entry-point")
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage remoteMessage) async {
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
  displayNotification(remoteMessage);
}

/// detect if app opened by selecting a notification
/// return selected notification payload
Future<String?> didNotificationLaunchApp() async {
  final NotificationAppLaunchDetails? notificationAppLaunchDetails = await flutterLocalNotificationsPlugin.getNotificationAppLaunchDetails();
  return notificationAppLaunchDetails?.notificationResponse?.payload;
}
