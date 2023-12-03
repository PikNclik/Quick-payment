// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'total_paid.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

_$_TotalPaid _$$_TotalPaidFromJson(Map json) => _$_TotalPaid(
      paid: json['paid'] == null
          ? null
          : TotalAmount.fromJson(
              Map<String, dynamic>.from(json['paid'] as Map)),
      pending: json['pending'] == null
          ? null
          : TotalAmount.fromJson(
              Map<String, dynamic>.from(json['pending'] as Map)),
    );

Map<String, dynamic> _$$_TotalPaidToJson(_$_TotalPaid instance) =>
    <String, dynamic>{
      'paid': instance.paid?.toJson(),
      'pending': instance.pending?.toJson(),
    };
