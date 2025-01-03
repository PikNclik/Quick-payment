/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'dart:ui';
import 'package:flutter/material.dart';

var pixelRatio = window.devicePixelRatio;

// Size in physical pixels
var physicalFlexSize = window.physicalSize;
var physicalWidth = physicalFlexSize.width;
var physicalHeight = physicalFlexSize.height;

// Size in logical pixels
var logicalFlexSize = window.physicalSize / pixelRatio;
var logicalWidth = logicalFlexSize.width;
var logicalHeight = logicalFlexSize.height;

// Padding in physical pixels
var padding = window.padding;

// Safe area paddings in logical pixels
var paddingLeft = window.padding.left / window.devicePixelRatio;
var paddingRight = window.padding.right / window.devicePixelRatio;
var paddingTop = window.padding.top / window.devicePixelRatio;
var paddingBottom = window.padding.bottom / window.devicePixelRatio;

// Safe area in logical pixels
var safeWidth = logicalWidth - paddingLeft - paddingRight;
var safeHeight = logicalHeight - paddingTop - paddingBottom;

enum FlexSize {
  xs, // 400 > 576
  sm, // 576 -> 768
  md, // 768 -> 992
  lg, // 992 -> 1200
  xl, // 1200 -> 1366
  xxl, // 1366 -> 1440
  xxxl, // more than 1440
}

var flexSize = FlexSize.xs;

/// calculate flex size depending on device screen width in pixels
void calcFlexSize(BuildContext context) {
  if (physicalWidth >= 576 && physicalWidth < 768) {
    flexSize = FlexSize.sm;
  } else if (physicalWidth >= 768 && physicalWidth < 992) {
    flexSize = FlexSize.md;
  } else if (physicalWidth >= 992 && physicalWidth < 1200) {
    flexSize = FlexSize.lg;
  } else if (physicalWidth >= 1200 && physicalWidth < 1366) {
    flexSize = FlexSize.xl;
  } else if (physicalWidth >= 1366 && physicalWidth < 1440) {
    flexSize = FlexSize.xxl;
  } else if (physicalWidth >= 1440) {
    flexSize = FlexSize.xxxl;
  }
}

extension FlexUtlis<T> on Map<FlexSize, T> {
  T? get value {
    switch (flexSize) {
      case FlexSize.xs:
        return this[FlexSize.xs] ?? this[FlexSize.sm] ?? this[FlexSize.md] ?? this[FlexSize.lg];
      case FlexSize.sm:
        return this[FlexSize.sm] ?? this[FlexSize.md] ?? this[FlexSize.lg];
      case FlexSize.md:
        return this[FlexSize.md] ?? this[FlexSize.lg];
      case FlexSize.lg:
        return this[FlexSize.lg];
      case FlexSize.xl:
        return this[FlexSize.xl] ?? this[FlexSize.lg];
      case FlexSize.xxl:
        return this[FlexSize.xxl] ?? this[FlexSize.xl] ?? this[FlexSize.lg];
      case FlexSize.xxxl:
        return this[FlexSize.xxxl] ?? this[FlexSize.xxl] ?? this[FlexSize.xl] ?? this[FlexSize.lg];
    }
  }
}
