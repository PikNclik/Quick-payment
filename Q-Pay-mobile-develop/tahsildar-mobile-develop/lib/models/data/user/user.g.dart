// GENERATED CODE - DO NOT MODIFY BY HAND

part of 'user.dart';

// **************************************************************************
// JsonSerializableGenerator
// **************************************************************************

_$_User _$$_UserFromJson(Map json) => _$_User(
      id: json['id'],
      fullName: json['full_name'] as String?,
      active: json['active'],
      phone: json['phone'],
      bankId: json['bank_id'],
      bankAccountNumber: json['bank_account_number'],
      rememberToken: json['remember_token'],
      createdAt: json['created_at'] as String?,
      updatedAt: json['updated_at'] as String?,
      accessToken: json['access_token'] as String?,
      bank: json['bank'] == null
          ? null
          : Bank.fromJson(Map<String, dynamic>.from(json['bank'] as Map)),
      media: (json['media'] as List<dynamic>?)
          ?.map((e) => MediaItem.fromJson(Map<String, dynamic>.from(e as Map)))
          .toList(),
      cityId: json['city_id'],
      city: json['city'] == null
          ? null
          : City.fromJson(Map<String, dynamic>.from(json['city'] as Map)),
      email: json['email'] as String?,
    );

Map<String, dynamic> _$$_UserToJson(_$_User instance) => <String, dynamic>{
      'id': instance.id,
      'full_name': instance.fullName,
      'active': instance.active,
      'phone': instance.phone,
      'bank_id': instance.bankId,
      'bank_account_number': instance.bankAccountNumber,
      'remember_token': instance.rememberToken,
      'created_at': instance.createdAt,
      'updated_at': instance.updatedAt,
      'access_token': instance.accessToken,
      'bank': instance.bank?.toJson(),
      'media': instance.media?.map((e) => e.toJson()).toList(),
      'city_id': instance.cityId,
      'city': instance.city?.toJson(),
      'email': instance.email,
    };
