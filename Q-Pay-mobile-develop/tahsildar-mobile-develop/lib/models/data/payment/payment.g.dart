// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'payment.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

_$_Payment _$$_PaymentFromJson(Map json) => _$_Payment(
      id: json['id'] as int?,
      payerName: json['payer_name'] as String?,
      payerMobileNumber: json['payer_mobile_number'] as String?,
      amount: json['amount'] as int?,
      details: json['details'] as String?,
      status: json['status'] as int?,
      expiryDate: json['expiry_date'] == null
          ? null
          : DateTime.parse(json['expiry_date'] as String),
      scheduledDate: json['scheduled_date'] == null
          ? null
          : DateTime.parse(json['scheduled_date'] as String),
      paidAt: json['paid_at'] == null
          ? null
          : DateTime.parse(json['paid_at'] as String),
      userId: json['user_id'] as int?,
      uuid: json['uuid'] as String?,
      createdAt: json['created_at'] == null
          ? null
          : DateTime.parse(json['created_at'] as String),
      updatedAt: json['updated_at'] == null
          ? null
          : DateTime.parse(json['updated_at'] as String),
    );

Map<String, dynamic> _$$_PaymentToJson(_$_Payment instance) =>
    <String, dynamic>{
      'id': instance.id,
      'payer_name': instance.payerName,
      'payer_mobile_number': instance.payerMobileNumber,
      'amount': instance.amount,
      'details': instance.details,
      'status': instance.status,
      'expiry_date': instance.expiryDate?.toIso8601String(),
      'scheduled_date': instance.scheduledDate?.toIso8601String(),
      'paid_at': instance.paidAt?.toIso8601String(),
      'user_id': instance.userId,
      'uuid': instance.uuid,
      'created_at': instance.createdAt?.toIso8601String(),
      'updated_at': instance.updatedAt?.toIso8601String(),
    };
