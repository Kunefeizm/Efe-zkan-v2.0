<?php
// button.php - Sitenin sağ altında yer alan sabit iletişim butonlarını içerir.
// DÜZELTME: Veriler artık panelden dinamik olarak çekiliyor.

require_once __DIR__ . '/../panel/iletisim/helper.php';
$contacts = getContactData();

// Tekil butona yönlendirme veya liste açma mantığı
function get_link_and_action($items, $type) {
    if (empty($items)) return ['link' => '#', 'action' => '', 'rel' => '', 'title' => '', 'target' => ''];
    
    $link = 'javascript:void(0)';
    $action = '';
    $rel = 'rel="nofollow"';
    $title = '';
    $target = '';

    if (count($items) === 1) {
        $item = $items[0];
        if ($type === 'email') {
            $link = 'mailto:' . htmlspecialchars($item);
            $title = 'E-posta gönder: ' . htmlspecialchars($item);
            $rel = '';
        } else {
            $number = $item['number'];
            $name = $item['name'];
            $link_prefix = ($type === 'whatsapp') ? 'https://wa.me/' : 'tel:';
            $link = $link_prefix . htmlspecialchars(preg_replace('/[^0-9]/', '', $number));
            $target = ($type === 'whatsapp') ? 'target="_blank"' : '';
            $title = ($type === 'whatsapp') ? 'WhatsApp ile mesaj gönder' : 'Telefonla ara';
            if ($name) $title .= ': ' . htmlspecialchars($name);
        }
    } else {
        $action = 'data-view-trigger="' . $type . 's"';
        $rel = ''; 
        $title = 'Diğer seçenekleri gör';
    }
    return ['link' => $link, 'action' => $action, 'rel' => $rel, 'title' => 'title="' . $title . '"', 'target' => $target];
}

$whatsapp_meta = get_link_and_action($contacts['whatsapps'], 'whatsapp');
$phone_meta = get_link_and_action($contacts['phones'], 'phone');
$email_meta = get_link_and_action($contacts['emails'], 'email');
$directions_url = !empty($contacts['map_url']) ? htmlspecialchars($contacts['map_url']) : '#';

?>

<!-- Hızlı İletişim Butonları -->
<div id="contact-buttons-wrapper">
    <!-- Masaüstü için Widget -->
    <div id="contact-widget-desktop" class="fixed bottom-8 right-8 z-50 hidden md:block">
        <div class="contact-widget-container">
            <!-- Ana Butonlar Görünümü -->
            <div id="contact-main-view" class="contact-view active">
                <?php if (!empty($contacts['whatsapps'])): ?>
                <a href="<?php echo $whatsapp_meta['link']; ?>" <?php echo $whatsapp_meta['action']; ?> <?php echo $whatsapp_meta['rel']; ?> <?php echo $whatsapp_meta['title']; ?> <?php echo $whatsapp_meta['target']; ?> class="contact-item whatsapp"><i class="fab fa-whatsapp"></i><span class="contact-item-text">WhatsApp</span></a>
                <?php endif; ?>
                <?php if (!empty($contacts['phones'])): ?>
                <a href="<?php echo $phone_meta['link']; ?>" <?php echo $phone_meta['action']; ?> <?php echo $phone_meta['rel']; ?> <?php echo $phone_meta['title']; ?> class="contact-item phone"><i class="fas fa-phone-alt"></i><span class="contact-item-text">Hemen Ara</span></a>
                <?php endif; ?>
                 <?php if (!empty($contacts['emails'])): ?>
                <a href="<?php echo $email_meta['link']; ?>" <?php echo $email_meta['action']; ?> <?php echo $email_meta['rel']; ?> <?php echo $email_meta['title']; ?> class="contact-item email"><i class="fas fa-envelope"></i><span class="contact-item-text">E-posta</span></a>
                <?php endif; ?>
                <?php if (!empty($contacts['map_url'])): ?>
                <a href="<?php echo $directions_url; ?>" target="_blank" rel="nofollow" class="contact-item location" title="Yol tarifi al"><i class="fas fa-map-marker-alt"></i><span class="contact-item-text">Yol Tarifi</span></a>
                <?php endif; ?>
            </div>
            <!-- Liste Görünümleri -->
            <?php if (count($contacts['whatsapps']) > 1): ?>
            <div id="contact-whatsapps-view" class="contact-view contact-list-view">
                <div class="contact-list-header"><button class="contact-back-button" data-view-trigger="main"><i class="fas fa-arrow-left"></i></button><h3 class="contact-list-title">WhatsApp Seçin</h3></div>
                <div class="contact-list-items">
                    <?php foreach ($contacts['whatsapps'] as $item):?>
                    <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $item['number'])); ?>" target="_blank" rel="nofollow" class="contact-list-item whatsapp">
                        <i class="fab fa-whatsapp"></i><span><?php echo htmlspecialchars($item['name']);?></span><i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (count($contacts['phones']) > 1): ?>
            <div id="contact-phones-view" class="contact-view contact-list-view">
                <div class="contact-list-header"><button class="contact-back-button" data-view-trigger="main"><i class="fas fa-arrow-left"></i></button><h3 class="contact-list-title">Numara Seçin</h3></div>
                <div class="contact-list-items">
                    <?php foreach ($contacts['phones'] as $item):?>
                    <a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $item['number'])); ?>" rel="nofollow" class="contact-list-item phone">
                        <i class="fas fa-phone-alt"></i><span><?php echo htmlspecialchars($item['name']);?></span><i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (count($contacts['emails']) > 1): ?>
            <div id="contact-emails-view" class="contact-view contact-list-view">
                <div class="contact-list-header"><button class="contact-back-button" data-view-trigger="main"><i class="fas fa-arrow-left"></i></button><h3 class="contact-list-title">E-posta Seçin</h3></div>
                <div class="contact-list-items">
                    <?php foreach ($contacts['emails'] as $item):?>
                    <a href="mailto:<?php echo htmlspecialchars($item); ?>" class="contact-list-item email">
                        <i class="fas fa-envelope"></i><span><?php echo htmlspecialchars($item);?></span><i class="fas fa-chevron-right"></i>
                    </a>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Mobil için Widget -->
    <div id="contact-widget-mobile-bar" class="md:hidden fixed bottom-0 left-0 w-full z-50">
        <div class="contact-widget-container mobile">
            <?php if (!empty($contacts['whatsapps'])): ?><a href="<?php echo $whatsapp_meta['link']; ?>" <?php echo $whatsapp_meta['action']; ?> <?php echo $whatsapp_meta['rel']; ?> <?php echo $whatsapp_meta['title']; ?> <?php echo $whatsapp_meta['target']; ?> class="contact-item mobile whatsapp"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
            <?php if (!empty($contacts['phones'])): ?><a href="<?php echo $phone_meta['link']; ?>" <?php echo $phone_meta['action']; ?> <?php echo $phone_meta['rel']; ?> <?php echo $phone_meta['title']; ?> class="contact-item mobile phone"><i class="fas fa-phone-alt"></i></a><?php endif; ?>
            <?php if (!empty($contacts['emails'])): ?><a href="<?php echo $email_meta['link']; ?>" <?php echo $email_meta['action']; ?> <?php echo $email_meta['rel']; ?> <?php echo $email_meta['title']; ?> class="contact-item mobile email"><i class="fas fa-envelope"></i></a><?php endif; ?>
            <?php if (!empty($contacts['map_url'])): ?><a href="<?php echo $directions_url; ?>" target="_blank" rel="nofollow" class="contact-item mobile location"><i class="fas fa-map-marker-alt"></i></a><?php endif; ?>
        </div>
    </div>
    
    <!-- Mobil Liste Görünümü Overlay -->
    <div id="contact-mobile-overlay" class="md:hidden fixed inset-0 z-[60] hidden">
        <div id="contact-mobile-backdrop" class="absolute inset-0 bg-black/50"></div>
        <div id="contact-mobile-sheet" class="absolute bottom-0 left-0 right-0">
             <?php if (count($contacts['whatsapps']) > 1): ?>
                <div id="contact-whatsapps-view-mobile" class="contact-view contact-list-view mobile">
                    <div class="contact-list-header"><h3 class="contact-list-title">WhatsApp Seçin</h3></div>
                    <div class="contact-list-items">
                        <?php foreach ($contacts['whatsapps'] as $item):?>
                        <a href="https://wa.me/<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $item['number'])); ?>" target="_blank" rel="nofollow" class="contact-list-item whatsapp"><i class="fab fa-whatsapp"></i><span><?php echo htmlspecialchars($item['name']);?></span><i class="fas fa-chevron-right"></i></a>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (count($contacts['phones']) > 1): ?>
                <div id="contact-phones-view-mobile" class="contact-view contact-list-view mobile">
                    <div class="contact-list-header"><h3 class="contact-list-title">Numara Seçin</h3></div>
                    <div class="contact-list-items">
                        <?php foreach ($contacts['phones'] as $item):?>
                        <a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9]/', '', $item['number'])); ?>" rel="nofollow" class="contact-list-item phone"><i class="fas fa-phone-alt"></i><span><?php echo htmlspecialchars($item['name']);?></span><i class="fas fa-chevron-right"></i></a>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (count($contacts['emails']) > 1): ?>
                <div id="contact-emails-view-mobile" class="contact-view contact-list-view mobile">
                    <div class="contact-list-header"><h3 class="contact-list-title">E-posta Seçin</h3></div>
                    <div class="contact-list-items">
                        <?php foreach ($contacts['emails'] as $item):?>
                        <a href="mailto:<?php echo htmlspecialchars($item); ?>" class="contact-list-item email"><i class="fas fa-envelope"></i><span><?php echo htmlspecialchars($item);?></span><i class="fas fa-chevron-right"></i></a>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
