import 'dart:io';

import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/notifications/notification_handler.dart';
import 'package:url_launcher/url_launcher_string.dart';

import 'config/http_overrides.dart';
import 'config/instance_config.dart';
import 'config/ui_config.dart';
import 'controllers/theme_controller.dart';
import 'events/bus_events.dart';
import 'network/config/http_config.dart';
import 'router/app_router.dart';
import 'storage/storage.dart';
import 'ui/core/flex/flex_utils.dart';
import 'ui/resources/themes/themes.dart';
import 'ui/resources/themes/themes_night.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await EasyLocalization.ensureInitialized();
  HttpOverrides.global = AppHttpOverrides();
  await AppStorage.storageConfig();
  ThemeController().init();
  await httpConfig();
  await notificationConfig();

  runApp(
    EasyLocalization(
      startLocale: Locale(AppStorage.getLanguage()),
      supportedLocales: const [Locale('en'), Locale('ar')],
      path: 'assets/localization',
      fallbackLocale: const Locale('en'),
      child: const MyApp(),
    ),
  );
}

class MyApp extends StatefulWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  @override
  void initState() {
    super.initState();
    calcFlexSize(context);

    uiConfig();

    // change Material-App current theme
    eventBus.on<ThemeChangedEvent>().listen((_) => setState(() {}));

    // hide soft keyboard when (non-context class) emit event
    eventBus.on<SoftKeyboardEvent>().listen((_) => hideSoftKeyboard(context));

    // logOut
    eventBus.on<UnauthorizedEvent>().listen((_) => _handleUnauthorizedEvent());

    eventBus.on<OutdatedVersionEvent>().listen((data) => _handleOutDatedVersionEvent(data.message));

  }
  bool _isOutDatedShowing = false;
  _handleOutDatedVersionEvent (String message) {
    if (_isOutDatedShowing) return;
    _isOutDatedShowing = true;
    showDialog(
        barrierDismissible :false,
        context: appRouter.navigatorKey.currentContext ?? context, builder:
      (context){
        return WillPopScope(
          onWillPop: ()async{
            return false;
          },
          child: AlertDialog(
            title: const Text("نسخة قديمة!"),
            content: Column (
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(message)
              ],
            ),
            actions: [
              TextButton(onPressed: (){
                if (Platform.isAndroid){
                  launchUrlString("https://play.google.com/store/apps/details?id=com.piknclk.qpay");
                }

              }, child: const Text("تحديث التطبيق"))
            ],
          ),
        );
      }).then((value) => _isOutDatedShowing = false);
  }

  /// logOut
  _handleUnauthorizedEvent() async {
    if (appRouter.current.name != Login.name) {
      await AuthenticationController.logOut();
      appRouter.replaceAll([const Login()]);
    }
  }

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      behavior: HitTestBehavior.translucent,
      onTap: () => hideSoftKeyboard(context),
      child: MaterialApp.router(
        debugShowCheckedModeBanner: false,
        routerDelegate: appRouter.delegate(),
        routeInformationParser: appRouter.defaultRouteParser(),
        title: 'Q-Pay',
        themeMode: findInstance<ThemeController>().themeMode.value,
        theme: lightTheme,
        darkTheme: darkTheme,
        locale: context.locale,
        localizationsDelegates: context.localizationDelegates,
        supportedLocales: context.supportedLocales,
      ),
    );
  }
}
