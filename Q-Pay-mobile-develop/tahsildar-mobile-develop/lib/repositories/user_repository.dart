/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com

import 'dart:async';

import 'package:dio/dio.dart';
import 'package:get_it/get_it.dart';
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/models/responses/base_response/base_response.dart';
import 'package:tahsaldar/network/user_rest_client/user_rest_client.dart';
import 'package:tahsaldar/storage/storage.dart';

import '../models/data/city/city.dart';
import 'base_repository.dart';

class UserRepository extends BaseRepository {
  final _userRestClient = Lazy<UserRestClient>(() => UserRestClient(GetIt.I.get<Dio>()));
  UserRestClient get userRestClient => _userRestClient.value;

  Future<BaseResponse<dynamic>> login(String number) {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.login(phone: number, cancelToken: cancelToken).onError((error, _) => catchError<dynamic>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<LoginResponse>> verifyCode(String number, String code) {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.verifyCode(number: number, code: code, cancelToken: cancelToken).onError((error, _) => catchError<LoginResponse>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<User>> register(String fullName, String bankId, String accountNumber, String cityId) {
    /// Complete info after login
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient
          .register(
            fullName: fullName,
            bankId: bankId,
            accountNumber: accountNumber,
            cityId: cityId,
            cancelToken: cancelToken,
          )
          .onError((error, _) => catchError<User>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<User>> updateUser(
    Map<String, dynamic> user,
  ) {
    /// Complete info after login
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.updateUser(user: FormData.fromMap(user), cancelToken: cancelToken).onError((error, _) => catchError<User>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<dynamic>> logout(String deviceId) {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.logOut(deviceId: deviceId, cancelToken: cancelToken).onError((error, _) => catchError<dynamic>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<dynamic>> setFcmToken(String token, String platform) {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.setFcmToken(token: token, platform: platform).onError((error, _) => catchError<dynamic>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<dynamic>> updateLanguage() {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.updateLanguage(language: AppStorage.getLanguage()).onError((error, _) => catchError<dynamic>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<dynamic>> removeFcmToken() {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.removeFcmToken().onError((error, _) => catchError<dynamic>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<User>> getUser() {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.getUser(cancelToken: cancelToken).onError((error, _) => catchError<User>(error)),
      cancelToken: cancelToken,
    );
  }

  Future<BaseResponse<List<City>>> getAddresses(int page, {String? query, bool isPaginate = false}) {
    final cancelToken = CancelToken();
    return getResponse(
      () => userRestClient.getAddresses(page: page, query: query, isPaginate: isPaginate, cancelToken: cancelToken).onError((error, _) => catchError<List<City>>(error)),
      cancelToken: cancelToken,
    );
  }
}