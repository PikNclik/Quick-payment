/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';

class TextView extends StatelessWidget {
  final String label;
  final double? maxWidth;
  final double? widthPercentage;
  final TextStyle? style;
  final TextOverflow textOverflow;
  final int maxLines;

  /// [Text] with [TextOverflow] to avoid error: "A RenderFlex overflowed by".
  ///
  /// [label] displayed String in [Text].
  ///
  /// [style] the applied [TextStyle] on [Text].
  ///
  /// [maxWidth] width of [Container] which wrapped the [Text].
  ///
  /// [widthPercentage] percentage of [screenSize], e.g. for 60% pass 0.6.
  ///
  /// [textOverflow] the applied [TextOverflow] on overFlow strings
  ///
  /// [maxLines] maxLines of [Text]
  ///
  /// be sure to pass one of [maxWidth] or [widthPercentage]
  const TextView({
    required this.label,
    this.maxWidth,
    this.widthPercentage,
    this.style,
    this.textOverflow = TextOverflow.ellipsis,
    this.maxLines = 1,
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final screenSize = MediaQuery.of(context).size;
    final width = widthPercentage != null ? screenSize.width * widthPercentage! : maxWidth ?? double.infinity;
    return Container(
      constraints: BoxConstraints(maxWidth: width),
      child: Text(
        label,
        style: style,
        overflow: textOverflow,
        maxLines: maxLines,
        softWrap: false,
        textAlign: TextAlign.start,
      ),
    );
  }
}