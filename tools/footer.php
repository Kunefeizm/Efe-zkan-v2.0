<?php
// tools/footer.php - Web sayfasının panelden yönetilen alt bilgi bölümü

require_once __DIR__ . '/../panel/ayarlar/helper.php';
require_once __DIR__ . '/../panel/footer/helper.php';

$siteSettings = getSiteSettings();
$footerData = getFooterData();
$footerLogoChoice = $footerData['logo']['choice'] ?? 'light';
$logoToUse = ($footerLogoChoice === 'light') 
    ? ($siteSettings['logo']['image_light'] ?: $siteSettings['logo']['image_default'])
    : ($siteSettings['logo']['image_default'] ?: $siteSettings['logo']['image_light']);
$logoText = $siteSettings['logo']['text'] ?? 'Logo';
$logoTextColor = ($footerLogoChoice === 'light') 
    ? ($siteSettings['logo']['color_light'] ?? '#FFFFFF') 
    : ($siteSettings['logo']['color_dark'] ?? '#1B2559');
?>
    <!-- ========== FOOTER ========== -->
    <footer class="bg-slate-800 text-slate-300">
        <div class="container-custom py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                <!-- Logo & Açıklama -->
                <div class="lg:col-span-2">
                    <a href="#" class="inline-block h-8 mb-4">
                    <?php
                        if ($siteSettings['logo']['type'] === 'image' && !empty($logoToUse)) {
                            echo '<img src="' . htmlspecialchars($logoToUse) . '" alt="' . htmlspecialchars($logoText) . '" class="h-8">';
                        } else {
                            echo '<span class="text-2xl font-bold" style="color:' . htmlspecialchars($logoTextColor) . '">' . htmlspecialchars($logoText) . '</span>';
                        }
                    ?>
                    </a>
                    <?php if (!empty($footerData['description'])): ?>
                    <p class="text-slate-400 pr-8"><?php echo htmlspecialchars($footerData['description']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Link Sütunları -->
                <?php foreach($footerData['link_columns'] as $column): ?>
                <div>
                    <h3 class="font-bold text-white text-lg mb-4"><?php echo htmlspecialchars($column['title']); ?></h3>
                    <ul class="space-y-3">
                        <?php foreach($column['links'] as $link): ?>
                        <li><a href="<?php echo htmlspecialchars($link['url']); ?>" class="text-slate-400 hover:text-white transition-colors"><?php echo htmlspecialchars($link['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>

                <!-- Sosyal Medya -->
                <?php if(!empty($footerData['socials'])): ?>
                <div>
                    <h3 class="font-bold text-white text-lg mb-4">Bizi Takip Edin</h3>
                    <div class="flex space-x-4">
                        <?php foreach($footerData['socials'] as $social): ?>
                        <a href="<?php echo htmlspecialchars($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-white transition-colors">
                            <i class="<?php echo htmlspecialchars($social['icon']); ?> text-xl"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($footerData['copyright'])): ?>
            <div class="border-t border-slate-700 mt-10 pt-8 text-center text-slate-500">
                <p><?php echo htmlspecialchars($footerData['copyright']); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </footer>
    
    <!-- DÜZELTME: script.php artık head.php içinden yüklendiği için buradaki satır kaldırıldı. -->
</body>
</html>
