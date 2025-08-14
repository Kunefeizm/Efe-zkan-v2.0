<?php
// panel/tools/footer.php - Merkezi Panel Alt Bölümü

// URL'den gelen status mesajını alıp bildirim için hazırla
$message = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
?>
            </main> <!-- <main> etiketi header.php'de açıldı -->
        </div> <!-- Ana içerik alanı div'i header.php'de açıldı -->
    </div> <!-- Flex container div'i header.php'de açıldı -->

    <!-- Bildirim (Toast) -->
    <?php if ($message): ?>
    <div id="toast-message" class="fixed top-6 right-6 bg-brand-success text-white px-6 py-3 rounded-2xl shadow-lg flex items-center gap-4 z-[100] toast-enter-from">
        <i class="fas fa-check-circle text-xl"></i>
        <span class="font-semibold"><?php echo $message; ?></span>
        <button id="toast-close-btn" class="text-lg font-bold leading-none ml-4 opacity-70 hover:opacity-100 transition-opacity">&times;</button>
    </div>
    <?php endif; ?>

    <!-- Silme Onay Modalı (Tüm sayfalarda ortak) -->
    <div id="delete-modal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-[99] hidden modal-backdrop">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md modal-content scale-95">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-brand-danger text-3xl"></i>
                </div>
                <h3 class="text-2xl leading-6 font-bold text-brand-navy mt-5">İçeriği Sil</h3>
                <div class="mt-2">
                    <p class="text-base text-brand-secondary-gray">Bu içeriği silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.</p>
                </div>
            </div>
            <div class="mt-8 flex justify-center gap-4">
                <button id="modal-cancel-btn" class="px-8 py-3 rounded-full text-base font-semibold bg-gray-200 text-brand-secondary-gray hover:bg-gray-300 transition-colors">İptal</button>
                <a id="modal-confirm-btn" href="#" class="px-8 py-3 rounded-full text-base font-semibold text-white bg-brand-danger hover:bg-red-700 transition-colors">Evet, Sil</a>
            </div>
        </div>
    </div>

    <!-- Merkezi JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toast (Bildirim) Yönetimi
        const toast = document.getElementById('toast-message');
        if (toast) {
            setTimeout(() => toast.classList.add('toast-enter-active'), 10);
            const closeToast = () => {
                toast.classList.add('toast-leave-to');
                toast.addEventListener('transitionend', () => toast.remove());
            };
            document.getElementById('toast-close-btn').addEventListener('click', closeToast);
            setTimeout(closeToast, 5000);
        }

        // Modal (Onay Penceresi) Yönetimi
        const modal = document.getElementById('delete-modal');
        if(modal) {
            const modalContent = modal.querySelector('.modal-content');
            const confirmBtn = document.getElementById('modal-confirm-btn');
            const cancelBtn = document.getElementById('modal-cancel-btn');
            
            const openModal = (deleteUrl) => {
                confirmBtn.href = deleteUrl;
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    modalContent.classList.remove('scale-95');
                }, 10);
            };

            const closeModal = () => {
                modalContent.classList.add('scale-95');
                modal.classList.remove('opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            };

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    // data-delete-url="sil.php?id=..." gibi bir attribute olmalı
                    const url = button.dataset.deleteUrl || button.getAttribute('href');
                    if(url) openModal(url);
                });
            });

            cancelBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        }
    });
    </script>
</body>
</html>
