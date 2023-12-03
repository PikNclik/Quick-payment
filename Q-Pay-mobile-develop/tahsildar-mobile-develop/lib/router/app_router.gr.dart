// **************************************************************************
// AutoRouteGenerator
// **************************************************************************

// GENERATED CODE - DO NOT MODIFY BY HAND

// **************************************************************************
// AutoRouteGenerator
// **************************************************************************
//
// ignore_for_file: type=lint

part of 'app_router.dart';

class _$AppRouter extends RootStackRouter {
  _$AppRouter([GlobalKey<NavigatorState>? navigatorKey]) : super(navigatorKey);

  @override
  final Map<String, PageFactory> pagesMap = {
    ImageCropper.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const ImageCropperScreen(),
      );
    },
    UpdateProfile.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const UpdateProfileScreen(),
      );
    },
    AddPayment.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const AddPaymentScreen(),
      );
    },
    Settings.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const SettingsScreen(),
      );
    },
    Notifications.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const NotificationsScreen(),
      );
    },
    TransactionsDetails.name: (routeData) {
      final args = routeData.argsAs<TransactionsDetailsArgs>();
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: TransactionsDetailsScreen(
          transaction: args.transaction,
          key: args.key,
        ),
      );
    },
    Profile.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const ProfileScreen(),
      );
    },
    Transactions.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const TransactionsScreen(),
      );
    },
    Main.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const MainScreen(),
      );
    },
    CompleteInfo.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const CompleteInfoScreen(),
      );
    },
    VerifyCode.name: (routeData) {
      final args = routeData.argsAs<VerifyCodeArgs>();
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: VerifyCodeScreen(
          mobile: args.mobile,
          key: args.key,
        ),
      );
    },
    Login.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const LoginScreen(),
      );
    },
    Initial.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const InitialScreen(),
      );
    },
  };

  @override
  List<RouteConfig> get routes => [
        RouteConfig(
          '/#redirect',
          path: '/',
          redirectTo: '/initial',
          fullMatch: true,
        ),
        RouteConfig(
          ImageCropper.name,
          path: '/image_cropper',
        ),
        RouteConfig(
          UpdateProfile.name,
          path: '/update_profile',
        ),
        RouteConfig(
          AddPayment.name,
          path: '/add_payment',
        ),
        RouteConfig(
          Settings.name,
          path: '/settings',
        ),
        RouteConfig(
          Notifications.name,
          path: '/notifications',
        ),
        RouteConfig(
          TransactionsDetails.name,
          path: '/transactions_details',
        ),
        RouteConfig(
          Profile.name,
          path: '/profile',
        ),
        RouteConfig(
          Transactions.name,
          path: '/transactions',
        ),
        RouteConfig(
          Main.name,
          path: '/main',
        ),
        RouteConfig(
          CompleteInfo.name,
          path: '/complete_info',
        ),
        RouteConfig(
          VerifyCode.name,
          path: '/verify_code',
        ),
        RouteConfig(
          Login.name,
          path: '/login',
        ),
        RouteConfig(
          Initial.name,
          path: '/initial',
        ),
      ];
}

/// generated route for
/// [ImageCropperScreen]
class ImageCropper extends PageRouteInfo<void> {
  const ImageCropper()
      : super(
          ImageCropper.name,
          path: '/image_cropper',
        );

  static const String name = 'ImageCropper';
}

/// generated route for
/// [UpdateProfileScreen]
class UpdateProfile extends PageRouteInfo<void> {
  const UpdateProfile()
      : super(
          UpdateProfile.name,
          path: '/update_profile',
        );

  static const String name = 'UpdateProfile';
}

/// generated route for
/// [AddPaymentScreen]
class AddPayment extends PageRouteInfo<void> {
  const AddPayment()
      : super(
          AddPayment.name,
          path: '/add_payment',
        );

  static const String name = 'AddPayment';
}

/// generated route for
/// [SettingsScreen]
class Settings extends PageRouteInfo<void> {
  const Settings()
      : super(
          Settings.name,
          path: '/settings',
        );

  static const String name = 'Settings';
}

/// generated route for
/// [NotificationsScreen]
class Notifications extends PageRouteInfo<void> {
  const Notifications()
      : super(
          Notifications.name,
          path: '/notifications',
        );

  static const String name = 'Notifications';
}

/// generated route for
/// [TransactionsDetailsScreen]
class TransactionsDetails extends PageRouteInfo<TransactionsDetailsArgs> {
  TransactionsDetails({
    required Payment transaction,
    Key? key,
  }) : super(
          TransactionsDetails.name,
          path: '/transactions_details',
          args: TransactionsDetailsArgs(
            transaction: transaction,
            key: key,
          ),
        );

  static const String name = 'TransactionsDetails';
}

class TransactionsDetailsArgs {
  const TransactionsDetailsArgs({
    required this.transaction,
    this.key,
  });

  final Payment transaction;

  final Key? key;

  @override
  String toString() {
    return 'TransactionsDetailsArgs{transaction: $transaction, key: $key}';
  }
}

/// generated route for
/// [ProfileScreen]
class Profile extends PageRouteInfo<void> {
  const Profile()
      : super(
          Profile.name,
          path: '/profile',
        );

  static const String name = 'Profile';
}

/// generated route for
/// [TransactionsScreen]
class Transactions extends PageRouteInfo<void> {
  const Transactions()
      : super(
          Transactions.name,
          path: '/transactions',
        );

  static const String name = 'Transactions';
}

/// generated route for
/// [MainScreen]
class Main extends PageRouteInfo<void> {
  const Main()
      : super(
          Main.name,
          path: '/main',
        );

  static const String name = 'Main';
}

/// generated route for
/// [CompleteInfoScreen]
class CompleteInfo extends PageRouteInfo<void> {
  const CompleteInfo()
      : super(
          CompleteInfo.name,
          path: '/complete_info',
        );

  static const String name = 'CompleteInfo';
}

/// generated route for
/// [VerifyCodeScreen]
class VerifyCode extends PageRouteInfo<VerifyCodeArgs> {
  VerifyCode({
    required String mobile,
    Key? key,
  }) : super(
          VerifyCode.name,
          path: '/verify_code',
          args: VerifyCodeArgs(
            mobile: mobile,
            key: key,
          ),
        );

  static const String name = 'VerifyCode';
}

class VerifyCodeArgs {
  const VerifyCodeArgs({
    required this.mobile,
    this.key,
  });

  final String mobile;

  final Key? key;

  @override
  String toString() {
    return 'VerifyCodeArgs{mobile: $mobile, key: $key}';
  }
}

/// generated route for
/// [LoginScreen]
class Login extends PageRouteInfo<void> {
  const Login()
      : super(
          Login.name,
          path: '/login',
        );

  static const String name = 'Login';
}

/// generated route for
/// [InitialScreen]
class Initial extends PageRouteInfo<void> {
  const Initial()
      : super(
          Initial.name,
          path: '/initial',
        );

  static const String name = 'Initial';
}
