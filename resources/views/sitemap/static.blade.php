<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ urldecode(route('home')) }}</loc>
        <changefreq>monthly</changefreq>
        <priority>1</priority>

    </url>
    <url>
        <loc>{{ urldecode(route('discuss.search')) }}</loc>
        <changefreq>monthly</changefreq>
        <priority>1</priority>

    </url>
    <url>
        <loc>{{ urldecode(route('project.search')) }}</loc>
        <changefreq>monthly</changefreq>
        <priority>1</priority>

    </url>

</urlset>
