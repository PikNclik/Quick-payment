import 'dart:io';

import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:image_fade/image_fade.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';

Widget logoPlaceholder(ThemeData theme) => Container(
      color: theme.colorScheme.background,
      padding: const EdgeInsets.all(6),
      child: SvgPicture.asset("logo".svgAsset),
    );

class AppImage extends StatelessWidget {
  final double? size;
  final String imageUrl;
  final bool isCircle;
  final BorderRadius? borderRadius;
  final bool isFile; // from internal device storage
  final double? imageResolution;
  final Widget? placeholder;
  final BoxFit? boxFit;
  const AppImage({
    Key? key,
    this.size,
    required this.imageUrl,
    this.isCircle = false,
    this.isFile = false,
    this.borderRadius,
    this.imageResolution,
    this.placeholder,
    this.boxFit,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: size,
      height: size,
      child: AspectRatio(
        aspectRatio: 1,
        child: isCircle
            ? ClipOval(
                child: _ImageWidget(
                  imageUrl: imageUrl,
                  imageResolution: size,
                  isFile: isFile,
                  boxFit: boxFit,
                ),
              )
            : ClipRRect(
                borderRadius: borderRadius ?? BorderRadius.circular(10),
                child: _ImageWidget(
                  imageUrl: imageUrl,
                  imageResolution: size,
                  isFile: isFile,
                  boxFit: boxFit,
                ),
              ),
      ),
    );
  }
}

class _ImageWidget extends StatelessWidget {
  final String imageUrl;
  final double? imageResolution;
  final bool isFile;
  final BoxFit? boxFit;
  const _ImageWidget({
    required this.imageUrl,
    this.imageResolution,
    this.isFile = false,
    this.boxFit,
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return imageUrl.contains("http")
        ? FancyShimmerImage(
            imageUrl: imageUrl,
            boxFit: boxFit ?? BoxFit.cover,
            shimmerBaseColor: Colors.grey[300] ?? Colors.grey.withOpacity(0.5),
            shimmerHighlightColor: Colors.grey[100] ?? Colors.grey.withOpacity(0.2),
          )
        : isFile
            ? ImageFade(
                image: FileImage(File(imageUrl)),
                fit: boxFit ?? BoxFit.cover,
                width: imageResolution,
                height: imageResolution,
              )
            : ImageFade(
                image: AssetImage(imageUrl),
                fit: boxFit ?? BoxFit.cover,
                width: imageResolution,
                height: imageResolution,
              );
  }
}
