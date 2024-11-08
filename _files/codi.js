/**
 * ----------------------------------------------------------------------------
 * codi.js
 * ----------------------------------------------------------------------------
 *
 * The script is included on the About page where the running version is
 * compared with this one here (latest_version), representing the most current
 * one.
 * Depending on the comparison, a message is displayed to the user.
 */

/**
 * The latest version of the application.
 * This variable holds the parsed version object of the latest version string.
 *
 * @type {Object}
 * @property {number} major - The major version number.
 * @property {number} minor - The minor version number.
 * @property {number} patch - The patch version number.
 */
var latest_version = parseVersionString('5.0.0');

/**
 * ----------------------------------------------------------------------------
 * Parse Version String.
 * ----------------------------------------------------------------------------
 *
 * Parses a version string into an object with major, minor, and patch properties.
 * It expects a version string of three blocks separated by '.', e.g. '3.1.002'.
 *
 * @param {string} str - The version string to parse.
 *
 * @returns {Object|boolean} An object with major, minor, and patch properties, or false if the input is not a string.
 */
function parseVersionString(str) {
  if (typeof (str) != 'string') {
    return false;
  }
  var x = str.split('.');
  //
  // Parse from string block or default to 0 if can't parse
  //
  var maj = parseInt(x[0]) || 0;
  var min = parseInt(x[1]) || 0;
  var pat = parseInt(x[2]) || 0;
  //
  // Return array
  //
  return {
    major: maj,
    minor: min,
    patch: pat
  }
}
