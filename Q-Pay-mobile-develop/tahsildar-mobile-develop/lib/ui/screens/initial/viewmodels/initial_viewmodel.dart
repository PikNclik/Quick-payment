/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// state management for UI
///
/// store and manage your liveData in [InitialParams].
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/viewmodels/base_viewmodel.dart';

import "initial_params.dart";

class InitialViewModel extends BaseViewModel {
  final _params = Lazy(() => InitialParams());
  InitialParams get params => _params.value;
}
