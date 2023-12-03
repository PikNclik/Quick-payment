import 'package:json_annotation/json_annotation.dart';

part 'list_response.g.dart';

@JsonSerializable(genericArgumentFactories: true)
class ListResponse<T> {
  final List<T>? data;
  final int? total;

  const ListResponse({this.data, this.total});

  factory ListResponse.fromJson(Map<String, dynamic> json, T Function(Object? json) fromJsonT) => _$ListResponseFromJson(
        json,
        (Object? json) {
          try {
            return fromJsonT(json);
          } catch (e) {
            return fromJsonT(<String, dynamic>{});
          }
        },
      );

  Map<String, dynamic> toJson(Object Function(T value) toJsonT) => _$ListResponseToJson(this, toJsonT);
}
