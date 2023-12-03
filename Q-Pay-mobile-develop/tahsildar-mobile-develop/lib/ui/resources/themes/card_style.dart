import 'package:flutter/material.dart';

import '../colors/colors.dart';

BoxDecoration themeCardStyle = BoxDecoration(
  color: Colors.white,
  borderRadius: BorderRadius.circular(10),
  boxShadow: const [
    BoxShadow(color: DesignColors.purple3, spreadRadius: 1, blurRadius: 4),
  ],
);

BoxDecoration transactionCardStyle = themeCardStyle;

BoxDecoration profileTileStyle = themeCardStyle;

BoxDecoration summaryCardStyle = themeCardStyle;

BoxDecoration settingsCardStyle = themeCardStyle;

BoxDecoration bottomNavigationBar = const BoxDecoration(
  color: Colors.white,
  boxShadow: [
    BoxShadow(color: DesignColors.purple3, spreadRadius: 2, blurRadius: 4),
  ],
);
