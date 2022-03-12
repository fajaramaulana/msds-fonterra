/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function returnFileSize(number) {
  if (number < 1048576) {
    return {
      realSize: number,
      converted: (number / 1024).toFixed(2) + "KB",
    };
  } else if (number >= 1048576) {
    return {
      realSize: number,
      converted: (number / 1048576).toFixed(1) + "MB",
    };
  }
}
