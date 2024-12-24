import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:image_picker/image_picker.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/extensions/live_data_extension.dart';
import 'package:tahsaldar/models/data_models.dart';

/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// declare and manage viewModel-liveData variables.
///
/// see: https://pub.dev/packages/flutterx_live_data
///
/// more details: https://medium.com/@aghiadodeh/flutter-live-data-tutorial-4c65f1b7ff5e

class ProfileParams {
  /// Default filter for total amount
  final month = DateTime.now().month.mmm.liveData;
  final year = DateTime.now().year.toString().liveData;
  final version =  "".liveData;

  final totalPaid = const TotalPaid().liveData;

  /// display image which picked from device gallery and uploaded to server
  MutableLiveData<XFile?> pickedImage = MutableLiveData();

  MutableLiveData<String?> mediaId = MutableLiveData(value: null);
}
