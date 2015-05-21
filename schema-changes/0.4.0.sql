ALTER TABLE `wp_huge_itslider_sliders` ADD COLUMN `autoplay` TINYINT(1) UNSIGNED NULL DEFAULT 1 AFTER `sl_loading_icon`;

ALTER TABLE `wp_huge_itslider_sliders` ADD COLUMN `fancybox` TINYINT(1) UNSIGNED NULL DEFAULT 0 AFTER `autoplay`;

ALTER TABLE `wp_huge_itslider_sliders` ADD COLUMN `default_fancybox` TINYINT(1) UNSIGNED NULL DEFAULT 1 AFTER `fancybox`;

