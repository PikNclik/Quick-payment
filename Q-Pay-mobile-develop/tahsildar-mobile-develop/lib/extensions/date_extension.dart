import 'package:easy_localization/easy_localization.dart';

const isoDateFormat = "yyyy-MM-dd";
const isoMonthFormat = "MMM dd, hh:mm a";
const isoDateTimeFormat = "dd-MM-yyyy , hh:mm a";
const isoTimeFormat = "hh:mm a";

extension DateTimeFormatter on DateTime {
  //String get timeFormat => DateFormat(isoTimeFormat, 'en').format(this).toString();
  String get dateFormat => DateFormat(isoDateFormat, 'en').format(this).toString();
  String get displayDate => DateFormat(isoDateFormat, 'en').format(this).toString();
  String get datetimeFormat => DateFormat(isoDateTimeFormat, 'en').format(this).toString();
  String get displayedDatetime => DateFormat(isoDateTimeFormat, 'en').format(this).toString();
  String get monthFormat => DateFormat("MMMM yyyy").format(toLocal()).toString();

  String formatDate(String format) {
    return DateFormat(format, 'en').format(toLocal()).toString();
  }

  /// The [mWeekday] may be 0 for Sunday, 1 for Monday, etc. up to 7 for Sunday.
  DateTime mostRecentWeekday(int mWeekday) => DateTime(year, month, day - (weekday - mWeekday) % 7);

  bool isSameDay(DateTime? dateTime) {
    if (dateTime == null) return true;
    return day == dateTime.day && month == dateTime.month && year == dateTime.year;
  }

  bool isSameMonth(DateTime? dateTime) {
    if (dateTime == null) return true;
    return month == dateTime.month && year == dateTime.year;
  }
}

extension DateExtension on String {
  /// used in [DateTime] format
  String addZero() {
    if (int.parse(this) <= 9) {
      return "0$this";
    }
    return this;
  }

  String formatStringDateTime() {
    try {
      DateFormat dateFormat = DateFormat("yyyy-MM-dd HH:mm:ss", 'en');
      DateTime dateTime = dateFormat.parse(this);
      return dateTime.displayedDatetime;
    } catch (ex) {
      DateFormat dateFormat = DateFormat("yyyy-MM-dd'T'HH:mm:ss.SSSZ", 'en');
      DateTime dateTime = dateFormat.parse(this);
      return dateTime.displayedDatetime;
    }
  }

  String displayedDate() {
    try {
      DateFormat dateFormat = DateFormat("yyyy-MM-dd'T'HH:mm:ss.SSSZ", 'en');
      DateTime dateTime = dateFormat.parse(this);
      return dateTime.displayDate;
    } catch (ex) {
      DateFormat dateFormat = DateFormat("yyyy-MM-dd", 'en');
      DateTime dateTime = dateFormat.parse(this);
      return dateTime.displayDate;
    }
  }

  DateTime dateTimeConverter({String? lang}) {
    DateTime date;
    try {
      /// convert from(yyyy-MM-dd hh:mm a) String  to DateTime
      var inputFormat = DateFormat('yyyy-MM-dd hh:mm a', lang);
      date = inputFormat.parse(this);
    } catch (ex) {
      /// convert from(yyyy-MM-dd) String  to DateTime
      var inputFormat = DateFormat('yyyy-MM-dd');
      date = inputFormat.parse(this);
    }
    return date;
  }

  DateTime isoStringToDate() {
    var inputFormat = DateFormat("yyyy-MM-dd'T'HH:mm:ss", 'en');
    return inputFormat.parse(split(".").first).toLocal();
  }
}

extension MonthsToString on int {
  String get mmm => monthsToString[this] ?? '';
}

extension MonthsToInteger on String {
  int get number => monthsToInteger[this] ?? 1;
}

/// Map months to their integers
Map<String, int> monthsToInteger = {
  "Jan": 1,
  "Feb": 2,
  "Mar": 3,
  "Apr": 4,
  "May": 5,
  "Jun": 6,
  "Jul": 7,
  "Aug": 8,
  "Sep": 9,
  "Oct": 10,
  "Nov": 11,
  "Dec": 12,
};

/// Map months to their String
Map<int, String> monthsToString = {
  1: "Jan",
  2: "Feb",
  3: "Mar",
  4: "Apr",
  5: "May",
  6: "Jun",
  7: "Jul",
  8: "Aug",
  9: "Sep",
  10: "Oct",
  11: "Nov",
  12: "Dec",
};

/// Months
List<String> months = [
  "Jan",
  "Feb",
  "Mar",
  "Apr",
  "May",
  "Jun",
  "Jul",
  "Aug",
  "Sep",
  "Oct",
  "Nov",
  "Dec",
];

/// Years
List<int> years = [for (var i = 2023; i < 2036; i += 1) i];
