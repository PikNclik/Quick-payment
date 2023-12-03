/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// state management for UI
///
/// store and manage your liveData in [TransactionsDetailsParams].
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/repositories/payment_repository.dart';
import 'package:tahsaldar/viewmodels/base_viewmodel.dart';

import "transactions_details_params.dart";

class TransactionsDetailsViewModel extends BaseViewModel {
  final _params = Lazy(() => TransactionsDetailsParams());
  TransactionsDetailsParams get params => _params.value;

  final _paymentRepository = Lazy(() => PaymentRepository());
  PaymentRepository get paymentRepository => _paymentRepository.value;

  @override
  void onInit() {
    super.onInit();
    getTransactionById();
  }

  @override
  void onDispose() {
    // called immediately before the widget is disposed
    super.onDispose();
  }

  double get paymentAmount => params.transaction.value.amount?.toDouble() ?? 0;

  ///Amount as double value
  double get calculateAmount => paymentAmount.toDouble();
  String get amount => paymentAmount.toDouble().toStringAsFixed(0);

  ///Fees as double value
  double get calculateFees => calculateAmount * 0.1;
  String get fees => calculateFees.toStringAsFixed(0);

  ///Total amount as double value
  double get calculateTotalAmount => calculateFees + calculateAmount;
  String get totalAmount => calculateTotalAmount.toStringAsFixed(0);

  getTransactionById() {
    callHttpRequest(
      () => paymentRepository.findOne(params.transaction.value.id.toString()),
      loading: baseParams.loading,
      callback: (response) {
        if (response != null) {
          params.transaction.postValue(response);
        }
      },
    );
  }
}
