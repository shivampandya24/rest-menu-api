
# REST Menu API Plugin for WordPress

This plugin exposes WordPress navigation menus and their items via custom REST API endpoints. It allows external applications to retrieve menu data from WordPress, making it useful for headless WordPress setups and custom frontend applications.

## Disclosure
This API makes your menu items available publicly.

## Features

-   Fetch menu items for a specific menu by menu name or ID.
-   Retrieve all registered menus along with their items.

## Endpoints
**Get Items of a Specific Menu**  
Endpoint: `/wp-json/menu/v1/items`  
**Query Parameter:** `menu` (string) - The menu name or ID.

**Example Request:**

    GET https://yourdomain.com/wp-json/menu/v1/items?menu=main-menu

**Example Response:**

    [
	    {
	        "id": 42,
	        "title": "Home",
	        "url": "https://yourdomain.com/",
	        "parent": "0",
	        "order": 1,
	        "classes": ["menu-item", "home"],
	        "type": "custom"
	    },
	    {
	        "id": 43,
	        "title": "About",
	        "url": "https://yourdomain.com/about/",
	        "parent": "0",
	        "order": 2,
	        "classes": ["menu-item"],
	        "type": "post_type"
	    }
	]

**Get All Menus and Their Items**  
Endpoint: `/wp-json/menu/v1/all`

**Example Request:**

    GET https://yourdomain.com/wp-json/menu/v1/all

**Example Response:**

    [
	    {
	        "menu_id": 1,
	        "menu_name": "Main Menu",
	        "menu_slug": "main-menu",
	        "items": [
	            {
	                "id": 42,
	                "title": "Home",
	                "url": "https://yourdomain.com/",
	                "parent": "0",
	                "order": 1,
	                "classes": ["menu-item", "home"],
	                "type": "custom"
	            },
	            {
	                "id": 43,
	                "title": "About",
	                "url": "https://yourdomain.com/about/",
	                "parent": "0",
	                "order": 2,
	                "classes": ["menu-item"],
	                "type": "post_type"
	            }
	        ]
	    },
	    {
	        "menu_id": 2,
	        "menu_name": "Footer Menu",
	        "menu_slug": "footer-menu",
	        "items": [
	            {
	                "id": 44,
	                "title": "Privacy Policy",
	                "url": "https://yourdomain.com/privacy-policy/",
	                "parent": "0",
	                "order": 1,
	                "classes": ["menu-item"],
	                "type": "custom"
	            }
	        ]
	    }
	]

## Installation

1.  Install the `WP REST Menu API` plugin.
2.  Go to the WordPress admin dashboard and navigate to **Plugins**.
3.  Find **REST Menu API** in the list and click **Activate**.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributing

1.  Fork the repository.
2.  Create a new branch for your feature (`git checkout -b feature/feature-name`).
3.  Commit your changes (`git commit -m 'Add new feature'`).
4.  Push to the branch (`git push origin feature/feature-name`).
5.  Open a pull request to the main branch.

## Security
We take the security of the API extremely seriously. If you think you've found a security issue with the API (whether information disclosure, privilege escalation, or another issue), we'd appreciate responsible disclosure as soon as possible.

To report a security issue, you can email to `shivampandya24[at]gmail.com`