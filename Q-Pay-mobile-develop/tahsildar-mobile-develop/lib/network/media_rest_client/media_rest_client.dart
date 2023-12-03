import 'package:dio/dio.dart';
import 'package:retrofit/retrofit.dart';

import '../../models/data/media_item/media_item.dart';
import '../../models/responses/base_response/base_response.dart';
import '../config/env.dart';

part 'media_rest_client.g.dart';

@RestApi(baseUrl: Env.apiUrl)
abstract class MediaRestClient {
  factory MediaRestClient(Dio dio) = _MediaRestClient;

  @POST("/upload-media")
  Future<BaseResponse<List<MediaItem>>> uploadMedia({
    @Body() required FormData formData,
  });

  @DELETE("/delete-media/{id}")
  Future<BaseResponse<dynamic>> deleteMedia({
    @Path() required String id,
  });
}
