// coverage:ignore-file
// GENERATED CODE - DO NOT MODIFY BY HAND
// ignore_for_file: type=lint
// ignore_for_file: unused_element, deprecated_member_use, deprecated_member_use_from_same_package, use_function_type_syntax_for_parameters, unnecessary_const, avoid_init_to_null, invalid_override_different_default_values_named, prefer_expression_function_bodies, annotate_overrides, invalid_annotation_target, unnecessary_question_mark

part of 'transfer.dart';

// **************************************************************************
// FreezedGenerator
// **************************************************************************

T _$identity<T>(T value) => value;

final _privateConstructorUsedError = UnsupportedError(
    'It seems like you constructed your class using `MyClass._()`. This constructor is only meant to be used by freezed and you are not supposed to need it nor use it.\nPlease check the documentation here for more information: https://github.com/rrousselGit/freezed#custom-getters-and-methods');

Transfer _$TransferFromJson(Map<String, dynamic> json) {
  return _Transfer.fromJson(json);
}

/// @nodoc
mixin _$Transfer {
  String? get bankId => throw _privateConstructorUsedError;
  String? get phone => throw _privateConstructorUsedError;
  int? get amount => throw _privateConstructorUsedError;
  String? get bankAccountNumber => throw _privateConstructorUsedError;
  String? get name => throw _privateConstructorUsedError;

  Map<String, dynamic> toJson() => throw _privateConstructorUsedError;
  @JsonKey(ignore: true)
  $TransferCopyWith<Transfer> get copyWith =>
      throw _privateConstructorUsedError;
}

/// @nodoc
abstract class $TransferCopyWith<$Res> {
  factory $TransferCopyWith(Transfer value, $Res Function(Transfer) then) =
      _$TransferCopyWithImpl<$Res, Transfer>;
  @useResult
  $Res call(
      {String? bankId,
      String? phone,
      int? amount,
      String? bankAccountNumber,
      String? name});
}

/// @nodoc
class _$TransferCopyWithImpl<$Res, $Val extends Transfer>
    implements $TransferCopyWith<$Res> {
  _$TransferCopyWithImpl(this._value, this._then);

  // ignore: unused_field
  final $Val _value;
  // ignore: unused_field
  final $Res Function($Val) _then;

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? bankId = freezed,
    Object? phone = freezed,
    Object? amount = freezed,
    Object? bankAccountNumber = freezed,
    Object? name = freezed,
  }) {
    return _then(_value.copyWith(
      bankId: freezed == bankId
          ? _value.bankId
          : bankId // ignore: cast_nullable_to_non_nullable
              as String?,
      phone: freezed == phone
          ? _value.phone
          : phone // ignore: cast_nullable_to_non_nullable
              as String?,
      amount: freezed == amount
          ? _value.amount
          : amount // ignore: cast_nullable_to_non_nullable
              as int?,
      bankAccountNumber: freezed == bankAccountNumber
          ? _value.bankAccountNumber
          : bankAccountNumber // ignore: cast_nullable_to_non_nullable
              as String?,
      name: freezed == name
          ? _value.name
          : name // ignore: cast_nullable_to_non_nullable
              as String?,
    ) as $Val);
  }
}

/// @nodoc
abstract class _$$_TransferCopyWith<$Res> implements $TransferCopyWith<$Res> {
  factory _$$_TransferCopyWith(
          _$_Transfer value, $Res Function(_$_Transfer) then) =
      __$$_TransferCopyWithImpl<$Res>;
  @override
  @useResult
  $Res call(
      {String? bankId,
      String? phone,
      int? amount,
      String? bankAccountNumber,
      String? name});
}

/// @nodoc
class __$$_TransferCopyWithImpl<$Res>
    extends _$TransferCopyWithImpl<$Res, _$_Transfer>
    implements _$$_TransferCopyWith<$Res> {
  __$$_TransferCopyWithImpl(
      _$_Transfer _value, $Res Function(_$_Transfer) _then)
      : super(_value, _then);

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? bankId = freezed,
    Object? phone = freezed,
    Object? amount = freezed,
    Object? bankAccountNumber = freezed,
    Object? name = freezed,
  }) {
    return _then(_$_Transfer(
      bankId: freezed == bankId
          ? _value.bankId
          : bankId // ignore: cast_nullable_to_non_nullable
              as String?,
      phone: freezed == phone
          ? _value.phone
          : phone // ignore: cast_nullable_to_non_nullable
              as String?,
      amount: freezed == amount
          ? _value.amount
          : amount // ignore: cast_nullable_to_non_nullable
              as int?,
      bankAccountNumber: freezed == bankAccountNumber
          ? _value.bankAccountNumber
          : bankAccountNumber // ignore: cast_nullable_to_non_nullable
              as String?,
      name: freezed == name
          ? _value.name
          : name // ignore: cast_nullable_to_non_nullable
              as String?,
    ));
  }
}

/// @nodoc
@JsonSerializable()
class _$_Transfer implements _Transfer {
  const _$_Transfer(
      {this.bankId,
      this.phone,
      this.amount,
      this.bankAccountNumber,
      this.name});

  factory _$_Transfer.fromJson(Map<String, dynamic> json) =>
      _$$_TransferFromJson(json);

  @override
  final String? bankId;
  @override
  final String? phone;
  @override
  final int? amount;
  @override
  final String? bankAccountNumber;
  @override
  final String? name;

  @override
  String toString() {
    return 'Transfer(bankId: $bankId, phone: $phone, amount: $amount, bankAccountNumber: $bankAccountNumber, name: $name)';
  }

  @override
  bool operator ==(dynamic other) {
    return identical(this, other) ||
        (other.runtimeType == runtimeType &&
            other is _$_Transfer &&
            (identical(other.bankId, bankId) || other.bankId == bankId) &&
            (identical(other.phone, phone) || other.phone == phone) &&
            (identical(other.amount, amount) || other.amount == amount) &&
            (identical(other.bankAccountNumber, bankAccountNumber) ||
                other.bankAccountNumber == bankAccountNumber) &&
            (identical(other.name, name) || other.name == name));
  }

  @JsonKey(ignore: true)
  @override
  int get hashCode =>
      Object.hash(runtimeType, bankId, phone, amount, bankAccountNumber, name);

  @JsonKey(ignore: true)
  @override
  @pragma('vm:prefer-inline')
  _$$_TransferCopyWith<_$_Transfer> get copyWith =>
      __$$_TransferCopyWithImpl<_$_Transfer>(this, _$identity);

  @override
  Map<String, dynamic> toJson() {
    return _$$_TransferToJson(
      this,
    );
  }
}

abstract class _Transfer implements Transfer {
  const factory _Transfer(
      {final String? bankId,
      final String? phone,
      final int? amount,
      final String? bankAccountNumber,
      final String? name}) = _$_Transfer;

  factory _Transfer.fromJson(Map<String, dynamic> json) = _$_Transfer.fromJson;

  @override
  String? get bankId;
  @override
  String? get phone;
  @override
  int? get amount;
  @override
  String? get bankAccountNumber;
  @override
  String? get name;
  @override
  @JsonKey(ignore: true)
  _$$_TransferCopyWith<_$_Transfer> get copyWith =>
      throw _privateConstructorUsedError;
}
