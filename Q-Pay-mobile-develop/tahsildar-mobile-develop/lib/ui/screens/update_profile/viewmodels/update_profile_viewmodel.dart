/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// state management for UI
///
/// store and manage your liveData in [UpdateProfileParams].
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/models/forms/formz_email.dart';
import 'package:tahsaldar/viewmodels/base_viewmodel.dart';

import '../../../../controllers/auth_controller.dart';
import '../../../../models/data/city/city.dart';
import '../../../../models/forms/formz_text.dart';
import '../../../../network/config/env.dart';
import '../../../../repositories/bank_repository.dart';
import '../../../../repositories/user_repository.dart';
import '../../../../router/app_router.dart';
import '../../../widgets/autocomplete_text_form_field/autocomplete_item_model.dart';
import "update_profile_params.dart";

class UpdateProfileViewModel extends BaseViewModel {
  final _params = Lazy(() => UpdateProfileParams());
  UpdateProfileParams get params => _params.value;

  final _userRepository = Lazy(() => UserRepository());
  UserRepository get userRepository => _userRepository.value;

  final _bankRepository = Lazy(() => BankRepository());
  BankRepository get bankRepository => _bankRepository.value;

  @override
  void onInit() {
    super.onInit();
    getBanks();
    getAddresses();
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
    callHttpRequest(() => bankRepository.findAll(Env.perPage, isPaginate: false), loading: baseParams.loading, callback: (response) {
      mapListOfBanksToAutoCompleteModel(response ?? []);
    });
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

  void attrChanged(MutableLiveData<FormzText> attr, String value) {
    final newValue = FormzText.dirty(value);
    attr.postValue(newValue);
    params.submit.postValue(params.isFormFilled());
  }

  void accountNumberChanged(MutableLiveData<FormzText> attr, String value) {
    final newValue = FormzText.dirty(value);
    attr.postValue(newValue);
    if (params.bankAccountNumber.inputValue() != params.confirmBankAccountNumber.inputValue()) {
      params.bankAccountMatch.postValue(false);
    } else {
      params.bankAccountMatch.postValue(true);
    }
    params.submit.postValue(params.isFormFilled());
  }

  void emailChanged(MutableLiveData<FormzEmail> attr, String value) {
    final newValue = FormzEmail.dirty(value);
    attr.postValue(newValue);
    params.submit.postValue(params.isFormFilled());
  }

  updateProfile() {
    callHttpRequest(
      () => userRepository.updateUser(params.mappingToFormData()),
      loading: baseParams.loading,
      callback: (response) async {
        if (response != null) {
          await AuthenticationController.saveUser(response);
          appRouter.replaceAll([const Main()]);
        }
      },
    );
  }
}
