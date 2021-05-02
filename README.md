# Advertising Settings Sidebar Panel

This is my submission for the Gutenberg Sidebar technical test for the Senior Engineer position.

## Approach

The following are the general description of how I went about implementing the task:

1. Register meta fields with their types and default values. Also included `auth_callback` to allow the protected fields to be updated.
2. Add a meta box, as for the classic editor, as fallback.
3. Test that meta fields are displayed and updated as expected.
4. Set up a developer environment for developing for the block editor:
    - [@wordpress/scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/) package for generating webpack configuration and utility scripts.
    - [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) package and Docker for setting up a local WordPress environment for building and testing the plugin.
5. Create the `AdvertisingSettingsPanel` component for generating the custom sidebar panel, and register a plugin to render it. I found [this guide](https://awhitepixel.com/blog/how-to-add-post-meta-fields-to-gutenberg-document-sidebar/) helpful for this task.
6. Add the three setting fields as required.
7. Test that the meta fields are updated as expected by inspecting the block editor data store in the browser dev tools, and updated in the database after publishing or updating the post.

## Testing

While I haven't set up automated unit tests for this plugin, the following are the cases that I would test:

| Context      | Action                            | Inputs                                                   | Expected Result                                                                                                                                                                               |
| ------------ | --------------------------------- | -------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Add new post | -                                 | -                                                        | The Advertising Settings custom panel is displayed in the block editor sidebar. The following fields are displayed on load: <br><br> - Advertisements: ON<br> - Commercial content type: None |
| Add new post | Set Advertisements field          | Toggle the Advertisements field to OFF.                  | The following fields are displayed:<br> - Advertisements: OFF<br> - Commercial content type: None                                                                                             |
| Add new post | Set Advertisements field          | Toggle the Advertisements field to ON.                   | The following fields are displayed:<br> - Advertisements: ON<br> - Commercial content type: None                                                                                              |
| Add new post | Set Commercial content type field | Select 'Sponsored' from Commercial content type options. | The following fields are displayed:<br> - Advertisements: ON<br> - Commercial content type: Sponsored<br> - Advertiser name: [empty]                                                          |
| Add new post | Set Advertiser name field         | Enter a name in the Advertiser name field.               | The following fields are displayed:<br> - Advertisements: ON<br> - Commercial content type: Sponsored<br> - Advertiser name: [the set name]                                                   |
| Add new post | Publish the post                  | Click Publish.                                           | The inputs are disabled while the post is being saved.                                                                                                                                        |
| Edit a post  | -                                 | -                                                        | The following fields are displayed (as set previously):<br> - Advertisements: ON<br> - Commercial content type: Sponsored<br> - Advertiser name: [the set name]                               |
