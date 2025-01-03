/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// state management for UI
///
/// store and manage your liveData in [CompleteInfoParams].
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/models/data/bank/bank.dart';
import 'package:tahsaldar/models/data/city/city.dart';
import 'package:tahsaldar/models/forms/formz_text.dart';
import 'package:tahsaldar/network/config/env.dart';
import 'package:tahsaldar/repositories/bank_repository.dart';
import 'package:tahsaldar/repositories/user_repository.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/widgets/autocomplete_text_form_field/autocomplete_item_model.dart';
import 'package:tahsaldar/viewmodels/base_viewmodel.dart';

import "complete_info_params.dart";

class CompleteInfoViewModel extends BaseViewModel {
  final _params = Lazy(() => CompleteInfoParams());

  CompleteInfoParams get params => _params.value;

  final _userRepository = Lazy(() => UserRepository());

  UserRepository get userRepository => _userRepository.value;

  final _bankRepository = Lazy(() => BankRepository());

  BankRepository get bankRepository => _bankRepository.value;

  @override
  void onInit() {
    super.onInit();
    getBanks();
  }

  mapListOfBanksToAutoCompleteModel(List<Bank> banks) {
    List<AutoCompleteItemModel> temp = [];
    if (banks.isNotEmpty) {
      for (var element in banks) {
        temp.add(AutoCompleteItemModel(id: element.id, value: element.name));
      }
    }
    params.banks.postValue(temp);
  }

  getBanks() {
    callHttpRequest(
      () => bankRepository.findAll(Env.perPage, isPaginate: false),
      loading: baseParams.loading,
      callback: (response) {
        mapListOfBanksToAutoCompleteModel(response ?? []);
        getAddresses();
      },
    );
  }

  void attrChanged(MutableLiveData<FormzText> attr, String value) {
    final newValue = FormzText.dirty(value);
    attr.postValue(newValue);
    params.submit.postValue(params.isFormFilled());
  }

  void accountNumberChanged(MutableLiveData<FormzText> attr, String value) {
    final newValue = FormzText.dirty(value);
    attr.postValue(newValue);
    if (params.bankAccountNumber.inputValue() !=
        params.confirmBankAccountNumber.inputValue()) {
      // this just to do a hard refresh for the livedata
      params.bankAccountMatch.postValue(true);
      params.bankAccountMatch.postValue(false);
    } else {
      params.bankAccountMatch.postValue(true);
    }
    params.submit.postValue(params.isFormFilled());
  }

  void passwordChanged(MutableLiveData<FormzText> attr, String value) {
    final newValue = FormzText.dirty(value);
    attr.postValue(newValue);
    if (params.password.inputValue() != params.confirmPassword.inputValue()) {
      // this just to do a hard refresh for the livedata
      params.passwordMatch.postValue(true);
      params.passwordMatch.postValue(false);
    } else {
      params.passwordMatch.postValue(true);
    }
    params.submit.postValue(params.isFormFilled());
  }

  completeInfo() {
    String fullName = params.fullName.inputValue();
    String bankId = params.bankId.inputValue();
    String accountNumber = params.bankAccountNumber.inputValue();
    String addressId = params.addressId.inputValue();
    String password = params.password.inputValue();
    callHttpRequest(
      () => userRepository.register(
          fullName, bankId, accountNumber, addressId, password),
      loading: baseParams.loading,
      callback: (response) async {
        if (response != null) {
          await AuthenticationController.login(response);
          appRouter.replaceAll([const Main()]);
        }
      },
    );
  }

  mapListOfAddressesToAutoCompleteModel(List<City> address) {
    List<AutoCompleteItemModel> temp = [];
    if (address.isNotEmpty) {
      for (var element in address) {
        temp.add(AutoCompleteItemModel(id: element.id, value: element.name));
      }
    }
    params.addresses.postValue(temp);
  }

  getAddresses() {
    callHttpRequest(
      () => userRepository.getAddresses(Env.perPage, isPaginate: false),
      loading: baseParams.loading,
      callback: (response) {
        mapListOfAddressesToAutoCompleteModel(response ?? []);
      },
    );
  }
}
