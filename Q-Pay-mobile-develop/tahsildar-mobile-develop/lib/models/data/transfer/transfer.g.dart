// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'transfer.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

_$_Transfer _$$_TransferFromJson(Map json) => _$_Transfer(
      bankId: json['bank_id'] as String?,
      phone: json['phone'] as String?,
      amount: json['amount'] as int?,
      bankAccountNumber: json['bank_account_number'] as String?,
      name: json['name'] as String?,
    );

Map<String, dynamic> _$$_TransferToJson(_$_Transfer instance) =>
    <String, dynamic>{
      'bank_id': instance.bankId,
      'phone': instance.phone,
      'amount': instance.amount,
      'bank_account_number': instance.bankAccountNumber,
      'name': instance.name,
    };
