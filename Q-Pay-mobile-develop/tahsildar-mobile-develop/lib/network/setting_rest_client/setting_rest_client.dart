/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:dio/dio.dart';
import 'package:retrofit/retrofit.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/models/responses/base_response/base_response.dart';
part 'setting_rest_client.g.dart';

@RestApi()
abstract class SettingRestClient {
  factory SettingRestClient(Dio dio) = _SettingRestClient;

  @GET("/settings")
  Future<BaseResponse<List<Setting>>> findAll({
    @CancelRequest() CancelToken? cancelToken,
  });

  @GET("/settings/get-by-key/{key_name}")
  Future<BaseResponse<Setting>> findOne({
    @Path("key_name") required String key,
    @CancelRequest() CancelToken? cancelToken,
  });
}
