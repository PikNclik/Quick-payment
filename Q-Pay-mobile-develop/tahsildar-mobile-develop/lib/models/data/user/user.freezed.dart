// coverage:ignore-file
// GENERATED CODE - DO NOT MODIFY BY HAND
// ignore_for_file: type=lint
// ignore_for_file: unused_element, deprecated_member_use, deprecated_member_use_from_same_package, use_function_type_syntax_for_parameters, unnecessary_const, avoid_init_to_null, invalid_override_different_default_values_named, prefer_expression_function_bodies, annotate_overrides, invalid_annotation_target, unnecessary_question_mark

part of 'user.dart';

// **************************************************************************
// FreezedGenerator
// **************************************************************************

T _$identity<T>(T value) => value;

final _privateConstructorUsedError = UnsupportedError(
    'It seems like you constructed your class using `MyClass._()`. This constructor is only meant to be used by freezed and you are not supposed to need it nor use it.\nPlease check the documentation here for more information: https://github.com/rrousselGit/freezed#custom-getters-and-methods');

User _$UserFromJson(Map<String, dynamic> json) {
  return _User.fromJson(json);
}

/// @nodoc
mixin _$User {
  dynamic get id => throw _privateConstructorUsedError;
  String? get fullName => throw _privateConstructorUsedError;
  dynamic get active => throw _privateConstructorUsedError;
  dynamic get phone => throw _privateConstructorUsedError;
  dynamic get bankId => throw _privateConstructorUsedError;
  dynamic get bankAccountNumber => throw _privateConstructorUsedError;
  dynamic get rememberToken => throw _privateConstructorUsedError;
  String? get createdAt => throw _privateConstructorUsedError;
  String? get updatedAt => throw _privateConstructorUsedError;
  String? get accessToken => throw _privateConstructorUsedError;
  Bank? get bank => throw _privateConstructorUsedError;
  List<MediaItem>? get media => throw _privateConstructorUsedError;
  dynamic get cityId => throw _privateConstructorUsedError;
  City? get city => throw _privateConstructorUsedError;
  String? get email => throw _privateConstructorUsedError;

  Map<String, dynamic> toJson() => throw _privateConstructorUsedError;
  @JsonKey(ignore: true)
  $UserCopyWith<User> get copyWith => throw _privateConstructorUsedError;
}

/// @nodoc
abstract class $UserCopyWith<$Res> {
  factory $UserCopyWith(User value, $Res Function(User) then) =
      _$UserCopyWithImpl<$Res, User>;
  @useResult
  $Res call(
      {dynamic id,
      String? fullName,
      dynamic active,
      dynamic phone,
      dynamic bankId,
      dynamic bankAccountNumber,
      dynamic rememberToken,
      String? createdAt,
      String? updatedAt,
      String? accessToken,
      Bank? bank,
      List<MediaItem>? media,
      dynamic cityId,
      City? city,
      String? email});

  $BankCopyWith<$Res>? get bank;
  $CityCopyWith<$Res>? get city;
}

/// @nodoc
class _$UserCopyWithImpl<$Res, $Val extends User>
    implements $UserCopyWith<$Res> {
  _$UserCopyWithImpl(this._value, this._then);

  // ignore: unused_field
  final $Val _value;
  // ignore: unused_field
  final $Res Function($Val) _then;

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? id = freezed,
    Object? fullName = freezed,
    Object? active = freezed,
    Object? phone = freezed,
    Object? bankId = freezed,
    Object? bankAccountNumber = freezed,
    Object? rememberToken = freezed,
    Object? createdAt = freezed,
    Object? updatedAt = freezed,
    Object? accessToken = freezed,
    Object? bank = freezed,
    Object? media = freezed,
    Object? cityId = freezed,
    Object? city = freezed,
    Object? email = freezed,
  }) {
    return _then(_value.copyWith(
      id: freezed == id
          ? _value.id
          : id // ignore: cast_nullable_to_non_nullable
              as dynamic,
      fullName: freezed == fullName
          ? _value.fullName
          : fullName // ignore: cast_nullable_to_non_nullable
              as String?,
      active: freezed == active
          ? _value.active
          : active // ignore: cast_nullable_to_non_nullable
              as dynamic,
      phone: freezed == phone
          ? _value.phone
          : phone // ignore: cast_nullable_to_non_nullable
              as dynamic,
      bankId: freezed == bankId
          ? _value.bankId
          : bankId // ignore: cast_nullable_to_non_nullable
              as dynamic,
      bankAccountNumber: freezed == bankAccountNumber
          ? _value.bankAccountNumber
          : bankAccountNumber // ignore: cast_nullable_to_non_nullable
              as dynamic,
      rememberToken: freezed == rememberToken
          ? _value.rememberToken
          : rememberToken // ignore: cast_nullable_to_non_nullable
              as dynamic,
      createdAt: freezed == createdAt
          ? _value.createdAt
          : createdAt // ignore: cast_nullable_to_non_nullable
              as String?,
      updatedAt: freezed == updatedAt
          ? _value.updatedAt
          : updatedAt // ignore: cast_nullable_to_non_nullable
              as String?,
      accessToken: freezed == accessToken
          ? _value.accessToken
          : accessToken // ignore: cast_nullable_to_non_nullable
              as String?,
      bank: freezed == bank
          ? _value.bank
          : bank // ignore: cast_nullable_to_non_nullable
              as Bank?,
      media: freezed == media
          ? _value.media
          : media // ignore: cast_nullable_to_non_nullable
              as List<MediaItem>?,
      cityId: freezed == cityId
          ? _value.cityId
          : cityId // ignore: cast_nullable_to_non_nullable
              as dynamic,
      city: freezed == city
          ? _value.city
          : city // ignore: cast_nullable_to_non_nullable
              as City?,
      email: freezed == email
          ? _value.email
          : email // ignore: cast_nullable_to_non_nullable
              as String?,
    ) as $Val);
  }

  @override
  @pragma('vm:prefer-inline')
  $BankCopyWith<$Res>? get bank {
    if (_value.bank == null) {
      return null;
    }

    return $BankCopyWith<$Res>(_value.bank!, (value) {
      return _then(_value.copyWith(bank: value) as $Val);
    });
  }

  @override
  @pragma('vm:prefer-inline')
  $CityCopyWith<$Res>? get city {
    if (_value.city == null) {
      return null;
    }

    return $CityCopyWith<$Res>(_value.city!, (value) {
      return _then(_value.copyWith(city: value) as $Val);
    });
  }
}

/// @nodoc
abstract class _$$_UserCopyWith<$Res> implements $UserCopyWith<$Res> {
  factory _$$_UserCopyWith(_$_User value, $Res Function(_$_User) then) =
      __$$_UserCopyWithImpl<$Res>;
  @override
  @useResult
  $Res call(
      {dynamic id,
      String? fullName,
      dynamic active,
      dynamic phone,
      dynamic bankId,
      dynamic bankAccountNumber,
      dynamic rememberToken,
      String? createdAt,
      String? updatedAt,
      String? accessToken,
      Bank? bank,
      List<MediaItem>? media,
      dynamic cityId,
      City? city,
      String? email});

  @override
  $BankCopyWith<$Res>? get bank;
  @override
  $CityCopyWith<$Res>? get city;
}

/// @nodoc
class __$$_UserCopyWithImpl<$Res> extends _$UserCopyWithImpl<$Res, _$_User>
    implements _$$_UserCopyWith<$Res> {
  __$$_UserCopyWithImpl(_$_User _value, $Res Function(_$_User) _then)
      : super(_value, _then);

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? id = freezed,
    Object? fullName = freezed,
    Object? active = freezed,
    Object? phone = freezed,
    Object? bankId = freezed,
    Object? bankAccountNumber = freezed,
    Object? rememberToken = freezed,
    Object? createdAt = freezed,
    Object? updatedAt = freezed,
    Object? accessToken = freezed,
    Object? bank = freezed,
    Object? media = freezed,
    Object? cityId = freezed,
    Object? city = freezed,
    Object? email = freezed,
  }) {
    return _then(_$_User(
      id: freezed == id
          ? _value.id
          : id // ignore: cast_nullable_to_non_nullable
              as dynamic,
      fullName: freezed == fullName
          ? _value.fullName
          : fullName // ignore: cast_nullable_to_non_nullable
              as String?,
      active: freezed == active
          ? _value.active
          : active // ignore: cast_nullable_to_non_nullable
              as dynamic,
      phone: freezed == phone
          ? _value.phone
          : phone // ignore: cast_nullable_to_non_nullable
              as dynamic,
      bankId: freezed == bankId
          ? _value.bankId
          : bankId // ignore: cast_nullable_to_non_nullable
              as dynamic,
      bankAccountNumber: freezed == bankAccountNumber
          ? _value.bankAccountNumber
          : bankAccountNumber // ignore: cast_nullable_to_non_nullable
              as dynamic,
      rememberToken: freezed == rememberToken
          ? _value.rememberToken
          : rememberToken // ignore: cast_nullable_to_non_nullable
              as dynamic,
      createdAt: freezed == createdAt
          ? _value.createdAt
          : createdAt // ignore: cast_nullable_to_non_nullable
              as String?,
      updatedAt: freezed == updatedAt
          ? _value.updatedAt
          : updatedAt // ignore: cast_nullable_to_non_nullable
              as String?,
      accessToken: freezed == accessToken
          ? _value.accessToken
          : accessToken // ignore: cast_nullable_to_non_nullable
              as String?,
      bank: freezed == bank
          ? _value.bank
          : bank // ignore: cast_nullable_to_non_nullable
              as Bank?,
      media: freezed == media
          ? _value._media
          : media // ignore: cast_nullable_to_non_nullable
              as List<MediaItem>?,
      cityId: freezed == cityId
          ? _value.cityId
          : cityId // ignore: cast_nullable_to_non_nullable
              as dynamic,
      city: freezed == city
          ? _value.city
          : city // ignore: cast_nullable_to_non_nullable
              as City?,
      email: freezed == email
          ? _value.email
          : email // ignore: cast_nullable_to_non_nullable
              as String?,
    ));
  }
}

/// @nodoc
@JsonSerializable()
class _$_User implements _User {
  const _$_User(
      {this.id,
      this.fullName,
      this.active,
      this.phone,
      this.bankId,
      this.bankAccountNumber,
      this.rememberToken,
      this.createdAt,
      this.updatedAt,
      this.accessToken,
      this.bank,
      final List<MediaItem>? media,
      this.cityId,
      this.city,
      this.email})
      : _media = media;

  factory _$_User.fromJson(Map<String, dynamic> json) => _$$_UserFromJson(json);

  @override
  final dynamic id;
  @override
  final String? fullName;
  @override
  final dynamic active;
  @override
  final dynamic phone;
  @override
  final dynamic bankId;
  @override
  final dynamic bankAccountNumber;
  @override
  final dynamic rememberToken;
  @override
  final String? createdAt;
  @override
  final String? updatedAt;
  @override
  final String? accessToken;
  @override
  final Bank? bank;
  final List<MediaItem>? _media;
  @override
  List<MediaItem>? get media {
    final value = _media;
    if (value == null) return null;
    if (_media is EqualUnmodifiableListView) return _media;
    // ignore: implicit_dynamic_type
    return EqualUnmodifiableListView(value);
  }

  @override
  final dynamic cityId;
  @override
  final City? city;
  @override
  final String? email;

  @override
  String toString() {
    return 'User(id: $id, fullName: $fullName, active: $active, phone: $phone, bankId: $bankId, bankAccountNumber: $bankAccountNumber, rememberToken: $rememberToken, createdAt: $createdAt, updatedAt: $updatedAt, accessToken: $accessToken, bank: $bank, media: $media, cityId: $cityId, city: $city, email: $email)';
  }

  @override
  bool operator ==(dynamic other) {
    return identical(this, other) ||
        (other.runtimeType == runtimeType &&
            other is _$_User &&
            const DeepCollectionEquality().equals(other.id, id) &&
            (identical(other.fullName, fullName) ||
                other.fullName == fullName) &&
            const DeepCollectionEquality().equals(other.active, active) &&
            const DeepCollectionEquality().equals(other.phone, phone) &&
            const DeepCollectionEquality().equals(other.bankId, bankId) &&
            const DeepCollectionEquality()
                .equals(other.bankAccountNumber, bankAccountNumber) &&
            const DeepCollectionEquality()
                .equals(other.rememberToken, rememberToken) &&
            (identical(other.createdAt, createdAt) ||
                other.createdAt == createdAt) &&
            (identical(other.updatedAt, updatedAt) ||
                other.updatedAt == updatedAt) &&
            (identical(other.accessToken, accessToken) ||
                other.accessToken == accessToken) &&
            (identical(other.bank, bank) || other.bank == bank) &&
            const DeepCollectionEquality().equals(other._media, _media) &&
            const DeepCollectionEquality().equals(other.cityId, cityId) &&
            (identical(other.city, city) || other.city == city) &&
            (identical(other.email, email) || other.email == email));
  }

  @JsonKey(ignore: true)
  @override
  int get hashCode => Object.hash(
      runtimeType,
      const DeepCollectionEquality().hash(id),
      fullName,
      const DeepCollectionEquality().hash(active),
      const DeepCollectionEquality().hash(phone),
      const DeepCollectionEquality().hash(bankId),
      const DeepCollectionEquality().hash(bankAccountNumber),
      const DeepCollectionEquality().hash(rememberToken),
      createdAt,
      updatedAt,
      accessToken,
      bank,
      const DeepCollectionEquality().hash(_media),
      const DeepCollectionEquality().hash(cityId),
      city,
      email);

  @JsonKey(ignore: true)
  @override
  @pragma('vm:prefer-inline')
  _$$_UserCopyWith<_$_User> get copyWith =>
      __$$_UserCopyWithImpl<_$_User>(this, _$identity);

  @override
  Map<String, dynamic> toJson() {
    return _$$_UserToJson(
      this,
    );
  }
}

abstract class _User implements User {
  const factory _User(
      {final dynamic id,
      final String? fullName,
      final dynamic active,
      final dynamic phone,
      final dynamic bankId,
      final dynamic bankAccountNumber,
      final dynamic rememberToken,
      final String? createdAt,
      final String? updatedAt,
      final String? accessToken,
      final Bank? bank,
      final List<MediaItem>? media,
      final dynamic cityId,
      final City? city,
      final String? email}) = _$_User;

  factory _User.fromJson(Map<String, dynamic> json) = _$_User.fromJson;

  @override
  dynamic get id;
  @override
  String? get fullName;
  @override
  dynamic get active;
  @override
  dynamic get phone;
  @override
  dynamic get bankId;
  @override
  dynamic get bankAccountNumber;
  @override
  dynamic get rememberToken;
  @override
  String? get createdAt;
  @override
  String? get updatedAt;
  @override
  String? get accessToken;
  @override
  Bank? get bank;
  @override
  List<MediaItem>? get media;
  @override
  dynamic get cityId;
  @override
  City? get city;
  @override
  String? get email;
  @override
  @JsonKey(ignore: true)
  _$$_UserCopyWith<_$_User> get copyWith => throw _privateConstructorUsedError;
}
