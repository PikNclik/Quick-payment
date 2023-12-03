import 'package:dio/dio.dart';
import 'package:get_it/get_it.dart';
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/models/data/media_item/media_item.dart';
import 'package:tahsaldar/models/responses/base_response/base_response.dart';

import '../network/media_rest_client/media_rest_client.dart';
import 'base_repository.dart';

class MediaRepository extends BaseRepository {
  final _mediaRestClient = Lazy<MediaRestClient>(() => MediaRestClient(GetIt.I.get<Dio>()));
  MediaRestClient get mediaRestClient => _mediaRestClient.value;

  Future<BaseResponse<List<MediaItem>>> uploadMedia(List<String> paths) async {
    final FormData formData = FormData();
    for (var i = 0; i < paths.length; i++) {
      formData.files.add(MapEntry("files[$i]", await MultipartFile.fromFile(paths[i])));
    }
    return getResponse(() async {
      return await mediaRestClient.uploadMedia(formData: formData).onError((error, _) => catchError<List<MediaItem>>(error));
    });
  }

  Future<BaseResponse<dynamic>> deleteMedia(String id) async {
    return getResponse(() async {
      return await mediaRestClient.deleteMedia(id: id).onError((error, _) => catchError<dynamic>(error));
    });
  }
}
