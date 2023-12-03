// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'media_item.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

_$_MediaItem _$$_MediaItemFromJson(Map json) => _$_MediaItem(
      id: json['id'],
      name: json['name'] as String?,
      originalUrl: json['original_url'] as String?,
      mimeType: json['mime_type'] as String?,
      collectionName: json['collection_name'] as String?,
    );

Map<String, dynamic> _$$_MediaItemToJson(_$_MediaItem instance) =>
    <String, dynamic>{
      'id': instance.id,
      'name': instance.name,
      'original_url': instance.originalUrl,
      'mime_type': instance.mimeType,
      'collection_name': instance.collectionName,
    };
