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
    Privacy.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const PrivacyScreen(),
      );
    },
    ResetPasswordRequest.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const ResetPasswordRequestScreen(),
      );
    },
    ResetPasswordVerification.name: (routeData) {
      final args = routeData.argsAs<ResetPasswordVerificationArgs>();
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: ResetPasswordVerificationScreen(
          key: args.key,
          mobile: args.mobile,
        ),
      );
    },
    ResetPassword.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const ResetPasswordScreen(),
      );
    },
    ChangePassword.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const ChangePasswordScreen(),
      );
    },
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
      final args = routeData.argsAs<AddPaymentArgs>(
          orElse: () => const AddPaymentArgs());
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: AddPaymentScreen(
          key: args.key,
          isUpdate: args.isUpdate,
          payment: args.payment,
        ),
      );
    },
    AddTransfer.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const AddTransferScreen(),
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
    TransferDetails.name: (routeData) {
      final args = routeData.argsAs<TransferDetailsArgs>();
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: TransferDetailsScreen(
          key: args.key,
          transfer: args.transfer,
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
    Transfers.name: (routeData) {
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: const TransfersScreen(),
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
    LoginPassword.name: (routeData) {
      final args = routeData.argsAs<LoginPasswordArgs>();
      return MaterialPageX<dynamic>(
        routeData: routeData,
        child: LoginPasswordScreen(
          key: args.key,
          mobile: args.mobile,
        ),
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
          Privacy.name,
          path: '/privacy',
        ),
        RouteConfig(
          ResetPasswordRequest.name,
          path: '/reset_password_request',
        ),
        RouteConfig(
          ResetPasswordVerification.name,
          path: '/reset_password_verification',
        ),
        RouteConfig(
          ResetPassword.name,
          path: '/reset_password',
        ),
        RouteConfig(
          ChangePassword.name,
          path: '/change_password',
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
          AddTransfer.name,
          path: '/add_transfer',
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
          TransferDetails.name,
          path: '/transfer_details',
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
          Transfers.name,
          path: '/transfers',
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
          LoginPassword.name,
          path: '/login_password',
        ),
        RouteConfig(
          Initial.name,
          path: '/initial',
        ),
      ];
}

/// generated route for
/// [PrivacyScreen]
class Privacy extends PageRouteInfo<void> {
  const Privacy()
      : super(
          Privacy.name,
          path: '/privacy',
        );

  static const String name = 'Privacy';
}

/// generated route for
/// [ResetPasswordRequestScreen]
class ResetPasswordRequest extends PageRouteInfo<void> {
  const ResetPasswordRequest()
      : super(
          ResetPasswordRequest.name,
          path: '/reset_password_request',
        );

  static const String name = 'ResetPasswordRequest';
}

/// generated route for
/// [ResetPasswordVerificationScreen]
class ResetPasswordVerification
    extends PageRouteInfo<ResetPasswordVerificationArgs> {
  ResetPasswordVerification({
    Key? key,
    required String mobile,
  }) : super(
          ResetPasswordVerification.name,
          path: '/reset_password_verification',
          args: ResetPasswordVerificationArgs(
            key: key,
            mobile: mobile,
          ),
        );

  static const String name = 'ResetPasswordVerification';
}

class ResetPasswordVerificationArgs {
  const ResetPasswordVerificationArgs({
    this.key,
    required this.mobile,
  });

  final Key? key;

  final String mobile;

  @override
  String toString() {
    return 'ResetPasswordVerificationArgs{key: $key, mobile: $mobile}';
  }
}

/// generated route for
/// [ResetPasswordScreen]
class ResetPassword extends PageRouteInfo<void> {
  const ResetPassword()
      : super(
          ResetPassword.name,
          path: '/reset_password',
        );

  static const String name = 'ResetPassword';
}

/// generated route for
/// [ChangePasswordScreen]
class ChangePassword extends PageRouteInfo<void> {
  const ChangePassword()
      : super(
          ChangePassword.name,
          path: '/change_password',
        );

  static const String name = 'ChangePassword';
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
class AddPayment extends PageRouteInfo<AddPaymentArgs> {
  AddPayment({
    Key? key,
    bool isUpdate = false,
    Payment? payment,
  }) : super(
          AddPayment.name,
          path: '/add_payment',
          args: AddPaymentArgs(
            key: key,
            isUpdate: isUpdate,
            payment: payment,
          ),
        );

  static const String name = 'AddPayment';
}

class AddPaymentArgs {
  const AddPaymentArgs({
    this.key,
    this.isUpdate = false,
    this.payment,
  });

  final Key? key;

  final bool isUpdate;

  final Payment? payment;

  @override
  String toString() {
    return 'AddPaymentArgs{key: $key, isUpdate: $isUpdate, payment: $payment}';
  }
}

/// generated route for
/// [AddTransferScreen]
class AddTransfer extends PageRouteInfo<void> {
  const AddTransfer()
      : super(
          AddTransfer.name,
          path: '/add_transfer',
        );

  static const String name = 'AddTransfer';
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
/// [TransferDetailsScreen]
class TransferDetails extends PageRouteInfo<TransferDetailsArgs> {
  TransferDetails({
    Key? key,
    required Payment transfer,
  }) : super(
          TransferDetails.name,
          path: '/transfer_details',
          args: TransferDetailsArgs(
            key: key,
            transfer: transfer,
          ),
        );

  static const String name = 'TransferDetails';
}

class TransferDetailsArgs {
  const TransferDetailsArgs({
    this.key,
    required this.transfer,
  });

  final Key? key;

  final Payment transfer;

  @override
  String toString() {
    return 'TransferDetailsArgs{key: $key, transfer: $transfer}';
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
/// [TransfersScreen]
class Transfers extends PageRouteInfo<void> {
  const Transfers()
      : super(
          Transfers.name,
          path: '/transfers',
        );

  static const String name = 'Transfers';
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
/// [LoginPasswordScreen]
class LoginPassword extends PageRouteInfo<LoginPasswordArgs> {
  LoginPassword({
    Key? key,
    required String mobile,
  }) : super(
          LoginPassword.name,
          path: '/login_password',
          args: LoginPasswordArgs(
            key: key,
            mobile: mobile,
          ),
        );

  static const String name = 'LoginPassword';
}

class LoginPasswordArgs {
  const LoginPasswordArgs({
    this.key,
    required this.mobile,
  });

  final Key? key;

  final String mobile;

  @override
  String toString() {
    return 'LoginPasswordArgs{key: $key, mobile: $mobile}';
  }
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
