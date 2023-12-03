// coverage:ignore-file
// GENERATED CODE - DO NOT MODIFY BY HAND
// ignore_for_file: type=lint
// ignore_for_file: unused_element, deprecated_member_use, deprecated_member_use_from_same_package, use_function_type_syntax_for_parameters, unnecessary_const, avoid_init_to_null, invalid_override_different_default_values_named, prefer_expression_function_bodies, annotate_overrides, invalid_annotation_target, unnecessary_question_mark

part of 'total_paid.dart';

// **************************************************************************
// FreezedGenerator
// **************************************************************************

T _$identity<T>(T value) => value;

final _privateConstructorUsedError = UnsupportedError(
    'It seems like you constructed your class using `MyClass._()`. This constructor is only meant to be used by freezed and you are not supposed to need it nor use it.\nPlease check the documentation here for more information: https://github.com/rrousselGit/freezed#custom-getters-and-methods');

TotalPaid _$TotalPaidFromJson(Map<String, dynamic> json) {
  return _TotalPaid.fromJson(json);
}

/// @nodoc
mixin _$TotalPaid {
  TotalAmount? get paid => throw _privateConstructorUsedError;
  TotalAmount? get pending => throw _privateConstructorUsedError;

  Map<String, dynamic> toJson() => throw _privateConstructorUsedError;
  @JsonKey(ignore: true)
  $TotalPaidCopyWith<TotalPaid> get copyWith =>
      throw _privateConstructorUsedError;
}

/// @nodoc
abstract class $TotalPaidCopyWith<$Res> {
  factory $TotalPaidCopyWith(TotalPaid value, $Res Function(TotalPaid) then) =
      _$TotalPaidCopyWithImpl<$Res, TotalPaid>;
  @useResult
  $Res call({TotalAmount? paid, TotalAmount? pending});

  $TotalAmountCopyWith<$Res>? get paid;
  $TotalAmountCopyWith<$Res>? get pending;
}

/// @nodoc
class _$TotalPaidCopyWithImpl<$Res, $Val extends TotalPaid>
    implements $TotalPaidCopyWith<$Res> {
  _$TotalPaidCopyWithImpl(this._value, this._then);

  // ignore: unused_field
  final $Val _value;
  // ignore: unused_field
  final $Res Function($Val) _then;

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? paid = freezed,
    Object? pending = freezed,
  }) {
    return _then(_value.copyWith(
      paid: freezed == paid
          ? _value.paid
          : paid // ignore: cast_nullable_to_non_nullable
              as TotalAmount?,
      pending: freezed == pending
          ? _value.pending
          : pending // ignore: cast_nullable_to_non_nullable
              as TotalAmount?,
    ) as $Val);
  }

  @override
  @pragma('vm:prefer-inline')
  $TotalAmountCopyWith<$Res>? get paid {
    if (_value.paid == null) {
      return null;
    }

    return $TotalAmountCopyWith<$Res>(_value.paid!, (value) {
      return _then(_value.copyWith(paid: value) as $Val);
    });
  }

  @override
  @pragma('vm:prefer-inline')
  $TotalAmountCopyWith<$Res>? get pending {
    if (_value.pending == null) {
      return null;
    }

    return $TotalAmountCopyWith<$Res>(_value.pending!, (value) {
      return _then(_value.copyWith(pending: value) as $Val);
    });
  }
}

/// @nodoc
abstract class _$$_TotalPaidCopyWith<$Res> implements $TotalPaidCopyWith<$Res> {
  factory _$$_TotalPaidCopyWith(
          _$_TotalPaid value, $Res Function(_$_TotalPaid) then) =
      __$$_TotalPaidCopyWithImpl<$Res>;
  @override
  @useResult
  $Res call({TotalAmount? paid, TotalAmount? pending});

  @override
  $TotalAmountCopyWith<$Res>? get paid;
  @override
  $TotalAmountCopyWith<$Res>? get pending;
}

/// @nodoc
class __$$_TotalPaidCopyWithImpl<$Res>
    extends _$TotalPaidCopyWithImpl<$Res, _$_TotalPaid>
    implements _$$_TotalPaidCopyWith<$Res> {
  __$$_TotalPaidCopyWithImpl(
      _$_TotalPaid _value, $Res Function(_$_TotalPaid) _then)
      : super(_value, _then);

  @pragma('vm:prefer-inline')
  @override
  $Res call({
    Object? paid = freezed,
    Object? pending = freezed,
  }) {
    return _then(_$_TotalPaid(
      paid: freezed == paid
          ? _value.paid
          : paid // ignore: cast_nullable_to_non_nullable
              as TotalAmount?,
      pending: freezed == pending
          ? _value.pending
          : pending // ignore: cast_nullable_to_non_nullable
              as TotalAmount?,
    ));
  }
}

/// @nodoc
@JsonSerializable()
class _$_TotalPaid implements _TotalPaid {
  const _$_TotalPaid({this.paid, this.pending});

  factory _$_TotalPaid.fromJson(Map<String, dynamic> json) =>
      _$$_TotalPaidFromJson(json);

  @override
  final TotalAmount? paid;
  @override
  final TotalAmount? pending;

  @override
  String toString() {
    return 'TotalPaid(paid: $paid, pending: $pending)';
  }

  @override
  bool operator ==(dynamic other) {
    return identical(this, other) ||
        (other.runtimeType == runtimeType &&
            other is _$_TotalPaid &&
            (identical(other.paid, paid) || other.paid == paid) &&
            (identical(other.pending, pending) || other.pending == pending));
  }

  @JsonKey(ignore: true)
  @override
  int get hashCode => Object.hash(runtimeType, paid, pending);

  @JsonKey(ignore: true)
  @override
  @pragma('vm:prefer-inline')
  _$$_TotalPaidCopyWith<_$_TotalPaid> get copyWith =>
      __$$_TotalPaidCopyWithImpl<_$_TotalPaid>(this, _$identity);

  @override
  Map<String, dynamic> toJson() {
    return _$$_TotalPaidToJson(
      this,
    );
  }
}

abstract class _TotalPaid implements TotalPaid {
  const factory _TotalPaid(
      {final TotalAmount? paid, final TotalAmount? pending}) = _$_TotalPaid;

  factory _TotalPaid.fromJson(Map<String, dynamic> json) =
      _$_TotalPaid.fromJson;

  @override
  TotalAmount? get paid;
  @override
  TotalAmount? get pending;
  @override
  @JsonKey(ignore: true)
  _$$_TotalPaidCopyWith<_$_TotalPaid> get copyWith =>
      throw _privateConstructorUsedError;
}
