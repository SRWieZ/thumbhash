# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2023-03-24

### Added
- Compatibility with PHP ^7.3
- Added convertStringToHash()

### Fixed
- Thumbhash::RGBAToHash() instead of Thumbhash::encode()

### Changed
- Downgrade dependencies: PestPHP ^2.0 => ^1.0 

First version
## [1.0] - 2023-03-23

## [1.2.0] - 2023-03-26

## Removed
- helpers functions
- static functions

## Added
- Compatibility with PHP ^8.0
- Constructor
- Private properties
- Added getWith(), getHeight(), gethHash(), displayThumbhash()
- Moved extract_size_and_pixels_with_gd() and extract_size_and_pixels_with_imagick() from helpers to Thumbhash object
