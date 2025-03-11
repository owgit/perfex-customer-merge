# GitHub Repository Setup Instructions

## Creating Your Repository

1. Go to GitHub and create a new repository
2. For maximum discoverability, use these settings:
   - Repository name: `perfex-customer-merge`
   - Description: `Customer Merge Module for Perfex CRM - Merge duplicate customers while preserving all associated data and relationships`
   - Make it Public
   - Do NOT initialize with README, .gitignore, or license (we already have these)

## Pushing Your Local Repository

After creating the repository on GitHub, run these commands to push your local repository:

```bash
# For HTTPS authentication
git remote add origin https://github.com/owgit/perfex-customer-merge.git
git branch -M main
git push -u origin main

# OR if you're using SSH authentication
git remote add origin git@github.com:owgit/perfex-customer-merge.git
git branch -M main
git push -u origin main
```

## Optimizing for Discoverability

After pushing your code:

1. Go to your repository settings
2. Add these topics to improve searchability:
   - perfex
   - perfexcrm
   - perfex-crm
   - crm
   - customer-management
   - merge
   - duplicate
   - deduplicate
   - php
   - module
   - extension
   - open-source

## Creating a Release

Once your code is pushed to GitHub, you can create a release:

1. Go to your repository on GitHub
2. Click on "Releases" in the right sidebar
3. Click "Create a new release"
4. Enter a tag version (e.g., "v1.0.0")
5. Enter a release title (e.g., "Perfex CRM Customer Merge Module v1.0.0")
6. Add release notes (you can copy from CHANGELOG.md)
7. Attach the ZIP file of your module if desired
8. Click "Publish release"

## Setting Up GitHub Pages (Optional)

To create a project website:

1. Go to your repository settings
2. Scroll down to "GitHub Pages"
3. Select the branch you want to use (usually "main")
4. Choose a theme if desired
5. Your site will be published at https://owgit.github.io/perfex-customer-merge/

## Promoting Your Module

Once published, consider:

1. Sharing on the Perfex CRM forums
2. Adding to Perfex CRM marketplace if available
3. Sharing on relevant PHP and CRM communities
4. Creating a blog post about it on your website 