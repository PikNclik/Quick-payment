class AutoCompleteItemModel {
  dynamic id;
  final dynamic value;
  final String? label;
  final dynamic data;
  AutoCompleteItemModel({
    required this.id,
    required this.value,
    this.data,
    this.label,
  });

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'value': value,
      'data': data,
      'label': label,
    };
  }
}
