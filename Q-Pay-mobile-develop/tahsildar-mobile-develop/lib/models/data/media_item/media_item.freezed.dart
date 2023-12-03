// coverage:ignore-file
// GENERATED CODE - DO NOT MODIFY BY HAND
// ignore_for_file: type=lint
// ignore_for_file: unused_element, deprecated_member_use, deprecated_member_use_from_same_package, use_function_type_syntax_for_parameters, unnecessary_const, avoid_init_to_null, invalid_override_different_default_values_named, prefer_expression_function_bodies, annotate_overrides, invalid_annotation_target, unnecessary_question_mark

part of 'media_item.dart';

// **************************************************************************
// FreezedGenerator
// **************************************************************************

T _$identity<T>(T value) => value;

final _privateConstructorUsedError = UnsupportedError(
    'It seems like you constructed your class using `MyClass._()`. This constructor is only meant to be used by freezed and you are not supposed to need it nor use it.\nPlease check the documentation here for more information: https://github.com/rrousselGit/freezed#custom-getters-and-methods');

MediaItem _$MediaItemFromJson(Map<String, dynamic> json) {
  return _MediaItem.fromJson(json);
}

/// @nodoc
mixin _$MediaItem {
  dynamic get id => throw _privateConstructorUsedError;
  String? get name => throw _privateConstructorUsedError;
  String? get originalUrl => throw _privateConstructorUsedError;
  @JsonKey(name: 'mime_type')
  String? get mimeType => throw _privateConstructorUsedError;
  @JsonKey(name: 'collection_name')
  String? get collectionName => throw _privateConstructorUsedError;

  Map<String, dynamic> toJson() => throw _privateConstructorUsedError;
  @JsonKey(ignore: true)
  $MediaItemCopyWith<MediaItem> get copyWith =>
      throw _privateConstructorUsedError;
}

/// @nodoc
abstract class $MediaItemCopyWith<$Res> {
  factory $MediaItemCopyWith(MediaItem value, $Res Function(MediaItem) then) =
      _$MediaItemCopyWithImpl<$Res, MediaItem>;
  @useResult
  $Res call(
      {dynamic id,
      String? name,
      String? originalUrl,
      @JsonKey(name: 'mime_type') String? mimeType,
      @JsonKey(name: 'collection_name') String? collectionName});
}

/// @nodoc
class _$MediaItemCopyWithImpl<$Res, $Val extends MediaItem>
    implements $MediaItemCopyWith<$Res> {
  _$MediaItemCopyWithImpl(this._value, this._then);

  // ignore: unused_field
  final $Val _value;
  // ignore: unused_field
  final $Res Function($Val) _then;

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? id = freezed,
    Object? name = freezed,
    Object? originalUrl = freezed,
    Object? mimeType = freezed,
    Object? collectionName = freezed,
  }) {
    return _then(_value.copyWith(
      id: freezed == id
          ? _value.id
          : id // ignore: cast_nullable_to_non_nullable
              as dynamic,
      name: freezed == name
          ? _value.name
          : name // ignore: cast_nullable_to_non_nullable
              as String?,
      originalUrl: freezed == originalUrl
          ? _value.originalUrl
          : originalUrl // ignore: cast_nullable_to_non_nullable
              as String?,
      mimeType: freezed == mimeType
          ? _value.mimeType
          : mimeType // ignore: cast_nullable_to_non_nullable
              as String?,
      collectionName: freezed == collectionName
          ? _value.collectionName
          : collectionName // ignore: cast_nullable_to_non_nullable
              as String?,
    ) as $Val);
  }
}

/// @nodoc
abstract class _$$_MediaItemCopyWith<$Res> implements $MediaItemCopyWith<$Res> {
  factory _$$_MediaItemCopyWith(
          _$_MediaItem value, $Res Function(_$_MediaItem) then) =
      __$$_MediaItemCopyWithImpl<$Res>;
  @override
  @useResult
  $Res call(
      {dynamic id,
      String? name,
      String? originalUrl,
      @JsonKey(name: 'mime_type') String? mimeType,
      @JsonKey(name: 'collection_name') String? collectionName});
}

/// @nodoc
class __$$_MediaItemCopyWithImpl<$Res>
    extends _$MediaItemCopyWithImpl<$Res, _$_MediaItem>
    implements _$$_MediaItemCopyWith<$Res> {
  __$$_MediaItemCopyWithImpl(
      _$_MediaItem _value, $Res Function(_$_MediaItem) _then)
      : super(_value, _then);

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? id = freezed,
    Object? name = freezed,
    Object? originalUrl = freezed,
    Object? mimeType = freezed,
    Object? collectionName = freezed,
  }) {
    return _then(_$_MediaItem(
      id: freezed == id
          ? _value.id
          : id // ignore: cast_nullable_to_non_nullable
              as dynamic,
      name: freezed == name
          ? _value.name
          : name // ignore: cast_nullable_to_non_nullable
              as String?,
      originalUrl: freezed == originalUrl
          ? _value.originalUrl
          : originalUrl // ignore: cast_nullable_to_non_nullable
              as String?,
      mimeType: freezed == mimeType
          ? _value.mimeType
          : mimeType // ignore: cast_nullable_to_non_nullable
              as String?,
      collectionName: freezed == collectionName
          ? _value.collectionName
          : collectionName // ignore: cast_nullable_to_non_nullable
              as String?,
    ));
  }
}

/// @nodoc
@JsonSerializable()
class _$_MediaItem implements _MediaItem {
  const _$_MediaItem(
      {this.id,
      this.name,
      this.originalUrl,
      @JsonKey(name: 'mime_type') this.mimeType,
      @JsonKey(name: 'collection_name') this.collectionName});

  factory _$_MediaItem.fromJson(Map<String, dynamic> json) =>
      _$$_MediaItemFromJson(json);

  @override
  final dynamic id;
  @override
  final String? name;
  @override
  final String? originalUrl;
  @override
  @JsonKey(name: 'mime_type')
  final String? mimeType;
  @override
  @JsonKey(name: 'collection_name')
  final String? collectionName;

  @override
  String toString() {
    return 'MediaItem(id: $id, name: $name, originalUrl: $originalUrl, mimeType: $mimeType, collectionName: $collectionName)';
  }

  @override
  bool operator ==(dynamic other) {
    return identical(this, other) ||
        (other.runtimeType == runtimeType &&
            other is _$_MediaItem &&
            const DeepCollectionEquality().equals(other.id, id) &&
            (identical(other.name, name) || other.name == name) &&
            (identical(other.originalUrl, originalUrl) ||
                other.originalUrl == originalUrl) &&
            (identical(other.mimeType, mimeType) ||
                other.mimeType == mimeType) &&
            (identical(other.collectionName, collectionName) ||
                other.collectionName == collectionName));
  }

  @JsonKey(ignore: true)
  @override
  int get hashCode => Object.hash(
      runtimeType,
      const DeepCollectionEquality().hash(id),
      name,
      originalUrl,
      mimeType,
      collectionName);

  @JsonKey(ignore: true)
  @override
  @pragma('vm:prefer-inline')
  _$$_MediaItemCopyWith<_$_MediaItem> get copyWith =>
      __$$_MediaItemCopyWithImpl<_$_MediaItem>(this, _$identity);

  @override
  Map<String, dynamic> toJson() {
    return _$$_MediaItemToJson(
      this,
    );
  }
}

abstract class _MediaItem implements MediaItem {
  const factory _MediaItem(
          {final dynamic id,
          final String? name,
          final String? originalUrl,
          @JsonKey(name: 'mime_type') final String? mimeType,
          @JsonKey(name: 'collection_name') final String? collectionName}) =
      _$_MediaItem;

  factory _MediaItem.fromJson(Map<String, dynamic> json) =
      _$_MediaItem.fromJson;

  @override
  dynamic get id;
  @override
  String? get name;
  @override
  String? get originalUrl;
  @override
  @JsonKey(name: 'mime_type')
  String? get mimeType;
  @override
  @JsonKey(name: 'collection_name')
  String? get collectionName;
  @override
  @JsonKey(ignore: true)
  _$$_MediaItemCopyWith<_$_MediaItem> get copyWith =>
      throw _privateConstructorUsedError;
}
