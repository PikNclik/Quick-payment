import 'package:animated_infinite_scroll_pagination/animated_infinite_scroll_pagination.dart';
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart' hide Notification;
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/ui/resources/dimensions/dimensions.dart';

import 'notification_widget.dart';

class NotificationListWidget extends StatelessWidget {
  final PaginationEquatable<Notification> notifications;
  const NotificationListWidget({required this.notifications, super.key});

  @override
  Widget build(BuildContext context) {
    final groupByDate = notifications.items.map((e) => e.item).toList().groupByDate();
    return Column(
      children: groupByDate.entries
          .map((group) => group.value.isEmpty
              ? const SizedBox()
              : Padding(
                  padding: const EdgeInsets.symmetric(horizontal: unitAndHalf),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Padding(
                        padding: const EdgeInsets.only(top: 20),
                        child: Text(group.key.tr()),
                      ),
                      ...group.value
                          .map(
                            (notification) => NotificationWidget(
                              notification: notification,
                              format: group.key == "today" || group.key == 'yesterday' ? isoTimeFormat : isoMonthFormat,
                            ),
                          )
                          .toList(),
                    ],
                  ),
                ))
          .toList(),
    );
  }
}
