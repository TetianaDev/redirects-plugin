# Redirects Plugin

This WordPress plugin enables the creation of redirects from a CSV file. It is designed for simplicity and efficiency, without an admin interface in its current stage.

## Instructions for Developers

### 1. No Admin Page
- The plugin currently does not have an admin page. Redirect rules are managed directly via a CSV file.

### 2. Source File Location and Format
- The CSV file containing redirect rules should be placed in the `source` folder within the plugin directory.
- Ensure the file is in CSV format.

### 3. CSV File Structure
- The CSV file must contain a header, as the first row is skipped during processing.
- It should have exactly three columns:
    - **Source URL**: The URL to be redirected from. It should not contain "/" at the end of the URL. Otherwise, the redirect probably will not work.
    - **Redirect Type**: The HTTP status code for the redirect (e.g., 301 for permanent redirect).
    - **Destination URL**: The URL where the traffic should be redirected to.

### 4. File Name Customization
- If the CSV file name is changed, ensure to update the file name in the `redirects.php` file, specifically in the `redirectsHandler()` method.

### 5. Caching and Updating Redirects
- Redirects are stored in a WordPress transient for performance optimization. The transient name is `redirects_data`.
- To update the redirects after modifying the CSV file, delete the transient. As it is set to be permanent, it will not expire on its own.
- Use `delete_transient('redirects_data')` to clear the cached data. Also, it can be done via additional plugin like [Transients Manager](https://wordpress.org/plugins/transients-manager/).