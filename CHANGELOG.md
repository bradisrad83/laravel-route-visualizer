# Changelog

All notable changes to `laravel-route-visualizer` will be documented in this file.

## [v1.0.1] - 2025-07-13
### Changed
- Wrapped route tables in a scrollable container with a `max-height` to prevent excessive page length when displaying a large number of routes.
- Improved visual structure by keeping table headers sticky while scrolling within the table.

## [v1.0.0] - 2025-06-15
### Added
- Initial release of `laravel-route-visualizer`.
- Visual UI for viewing all registered Laravel routes grouped by middleware or controller.
- Route tables display method, URI, name, action, and middleware.
- Search/filter functionality included via Alpine.js.