import 'package:easy_localization/easy_localization.dart';
import 'package:tahsaldar/models/data_models.dart';

import '../controllers/auth_controller.dart';

class FakeUtil {
  static String getCurrency (){
    if (user.isFake()){
      return "fake_currency".tr();
    }
    return "sp".tr();
  }
}