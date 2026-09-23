/**
 * STYLEVERA.JS — Complete Frontend JS
 * Golden Animated Dots · Dark Mode · Cart · S3 Upload · VMM Modal
 */
(function ($) {
  'use strict';

  const CSRF = $('meta[name="csrf-token"]').attr('content') || '';

  /* ══════════════════════════════════════════════════════════
     ANIMATED GOLDEN DOTS BACKGROUND
     Colors matching the city network image:
     warm gold dots (#C9A84C family) with slow gentle movement,
     glowing cores, connecting lines on proximity — very slight
  ══════════════════════════════════════════════════════════ */
  (function initDots() {
    const canvas = document.createElement('canvas');
    canvas.className = 'sv-dots-canvas';
    canvas.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;';
    document.body.insertBefore(canvas, document.body.firstChild);
    const ctx = canvas.getContext('2d');

    const DARK = () => document.body.classList.contains('dark-mode');
    let W = 0, H = 0, dots = [];

    const CFG = {
      count:  58,
      speed:  0.20,       // very slow drift
      maxDist: 155,       // connection distance
      minR: 1.4,
      maxR: 2.8,
      // light mode colours
      lightDot:  [201, 168, 76],   // warm gold core
      lightLine: [180, 140, 50],
      lightAlpha: 0.22,
      lightLine_a: 0.10,
      // dark mode colours
      darkDot:  [220, 190, 90],
      darkLine: [195, 160, 55],
      darkAlpha: 0.16,
      darkLine_a: 0.08,
    };

    function resize() {
      W = canvas.width  = window.innerWidth;
      H = canvas.height = window.innerHeight;
    }

    function mkDot() {
      return {
        x: Math.random() * W,
        y: Math.random() * H,
        vx: (Math.random() - 0.5) * CFG.speed,
        vy: (Math.random() - 0.5) * CFG.speed,
        r: CFG.minR + Math.random() * (CFG.maxR - CFG.minR),
        phase: Math.random() * Math.PI * 2,
        phaseSpeed: 0.006 + Math.random() * 0.007,
      };
    }

    function init() { resize(); dots = Array.from({ length: CFG.count }, mkDot); }

    function draw() {
      ctx.clearRect(0, 0, W, H);
      const dark = DARK();
      const dc  = dark ? CFG.darkDot  : CFG.lightDot;
      const lc  = dark ? CFG.darkLine : CFG.lightLine;
      const da  = dark ? CFG.darkAlpha  : CFG.lightAlpha;
      const la  = dark ? CFG.darkLine_a : CFG.lightLine_a;

      // Connecting lines
      for (let i = 0; i < dots.length; i++) {
        for (let j = i + 1; j < dots.length; j++) {
          const dx = dots[i].x - dots[j].x;
          const dy = dots[i].y - dots[j].y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < CFG.maxDist) {
            const a = la * (1 - dist / CFG.maxDist);
            ctx.beginPath();
            ctx.strokeStyle = `rgba(${lc[0]},${lc[1]},${lc[2]},${a.toFixed(3)})`;
            ctx.lineWidth = 0.6;
            ctx.moveTo(dots[i].x, dots[i].y);
            ctx.lineTo(dots[j].x, dots[j].y);
            ctx.stroke();
          }
        }
      }

      // Dots with glow
      dots.forEach(d => {
        d.phase += d.phaseSpeed;
        const pulse = Math.sin(d.phase) * 0.35 + 0.65; // 0.3 to 1.0
        const alpha = da * pulse;

        // Outer glow halo
        const grad = ctx.createRadialGradient(d.x, d.y, 0, d.x, d.y, d.r * 3.5);
        grad.addColorStop(0, `rgba(${dc[0]},${dc[1]},${dc[2]},${(alpha * 0.55).toFixed(3)})`);
        grad.addColorStop(1, `rgba(${dc[0]},${dc[1]},${dc[2]},0)`);
        ctx.beginPath();
        ctx.arc(d.x, d.y, d.r * 3.5, 0, Math.PI * 2);
        ctx.fillStyle = grad;
        ctx.fill();

        // Bright core
        ctx.beginPath();
        ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${dc[0]},${dc[1]},${dc[2]},${Math.min(1, alpha * 1.6).toFixed(3)})`;
        ctx.fill();

        // Move
        d.x += d.vx; d.y += d.vy;
        if (d.x < -30) d.x = W + 30;
        if (d.x > W + 30) d.x = -30;
        if (d.y < -30) d.y = H + 30;
        if (d.y > H + 30) d.y = -30;
      });

      requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    init();
    draw();
  })();

  /* ══════════════════════════════════════════════════════════
     DARK MODE
  ══════════════════════════════════════════════════════════ */
  if (localStorage.getItem('sv_dark') === '1') {
    document.body.classList.add('dark-mode');
    const icon = document.getElementById('svModeIcon');
    if (icon) icon.className = 'bi bi-sun';
  }
  window.toggleMode = function () {
    const dark = document.body.classList.toggle('dark-mode');
    localStorage.setItem('sv_dark', dark ? '1' : '0');
    const icon = document.getElementById('svModeIcon');
    if (icon) icon.className = dark ? 'bi bi-sun' : 'bi bi-moon';
  };

  /* ══════════════════════════════════════════════════════════
     TOAST NOTIFICATIONS
  ══════════════════════════════════════════════════════════ */
  window.svToast = function (msg, type) {
    type = type || 'info';
    const icons = {
      success: 'bi-check-circle-fill',
      error:   'bi-exclamation-circle-fill',
      info:    'bi-stars'
    };
    let $c = $('#svToastWrap');
    if (!$c.length) $c = $('<div id="svToastWrap" class="sv-toast-container"></div>').appendTo('body');
    const $t = $(`<div class="sv-toast t-${type}"><i class="bi ${icons[type] || icons.info}"></i><span>${msg}</span></div>`);
    $c.append($t);
    setTimeout(() => {
      $t.css({ transition: 'all .4s', opacity: 0, transform: 'translateX(110%)' });
      setTimeout(() => $t.remove(), 400);
    }, 3600);
  };

  /* ══════════════════════════════════════════════════════════
     LIGHTBOX
  ══════════════════════════════════════════════════════════ */
  window.svLightbox = function (url, type) {
    const $lb = $('#svLightbox');
    if (!$lb.length) return;
    $lb.find('img,video').hide().attr('src', '');
    if (type === 'video') { $lb.find('video').attr('src', url).show()[0].play(); }
    else { $lb.find('img').attr('src', url).show(); }
    $lb.addClass('active');
    $('body').css('overflow', 'hidden');
  };
  window.svLightboxClose = function () {
    $('#svLightbox').removeClass('active').find('video').each(function () { this.pause(); });
    $('body').css('overflow', '');
  };
  $(document).on('keydown', e => { if (e.key === 'Escape') { svLightboxClose(); svCloseVMM && svCloseVMM(); } });

  /* ══════════════════════════════════════════════════════════
     PRODUCT CARD — Multi-Image Hover Cycling with Dots
  ══════════════════════════════════════════════════════════ */
  $(document).on('mouseenter', '.sv-multi-img', function () {
    const $el = $(this);
    const raw = $el.data('images');
    if (!raw) return;
    const imgs = raw.toString().split('||').filter(Boolean);
    if (imgs.length < 2) return;

    let idx = 0;
    const $img  = $el.find('.sv-main-img');
    const $dots = $el.find('.sv-img-dot');

    const timer = setInterval(() => {
      idx = (idx + 1) % imgs.length;
      $img.attr('src', imgs[idx]);
      $dots.removeClass('active').eq(idx).addClass('active');
    }, 720);

    $el.data('sv_timer', timer);
  }).on('mouseleave', '.sv-multi-img', function () {
    const $el = $(this);
    clearInterval($el.data('sv_timer'));
    const orig = $el.data('original-src');
    if (orig) $el.find('.sv-main-img').attr('src', orig);
    $el.find('.sv-img-dot').removeClass('active').first().addClass('active');
  });

  /* ══════════════════════════════════════════════════════════
     CART
  ══════════════════════════════════════════════════════════ */
  $.get('/cart/count').done(d => { if (d.count !== undefined) _setCount(d.count); });

  function _setCount(n) {
    $('.cart-count').text('(' + n + ')');
    $('.sv-cart-badge').text(n);
  }

  window.svAddToCart = function (pid, vid, qty) {
    $.post('/cart/add', { _token: CSRF, product_id: pid, variant_id: vid || null, quantity: qty || 1 })
      .done(d => {
        if (d.success) { svToast(d.message, 'success'); _setCount(d.count); }
        else svToast(d.message || 'Error', 'error');
      }).fail(() => svToast('Error adding to cart', 'error'));
  };

  $(document).on('show.bs.offcanvas', '#offcanvasCart', () => {
    $.get('/cart/items').done(d => {
      if (d.html) $('#svCartItems').html(d.html);
      if (d.total) $('#svCartTotal').text(d.total);
      _setCount(d.count);
    });
  });

  $(document).on('click', '.sv-qty-btn', function () {
    $.post('/cart/update', { _token: CSRF, item_id: $(this).data('item-id'), action: $(this).data('action') })
      .done(d => {
        if (d.success) { $('#svCartItems').html(d.html); $('#svCartTotal').text(d.total); _setCount(d.count); }
      });
  });

  /* ══════════════════════════════════════════════════════════
     WISHLIST
  ══════════════════════════════════════════════════════════ */
  window.svToggleWishlist = function (pid, btn) {
    $.post('/wishlist/toggle', { _token: CSRF, product_id: pid })
      .done(d => {
        $(btn)[d.wishlisted ? 'addClass' : 'removeClass']('wishlisted');
        svToast(d.wishlisted ? 'Added to wishlist!' : 'Removed from wishlist', d.wishlisted ? 'success' : 'info');
        $('.wishlist-count').text('(' + d.count + ')');
      });
  };
  /* ══════════════════════════════════════════════════════════
     PRODUCT PAGE — Variant Selector
     Handled by product.blade.php inline script.
     This section removed to prevent conflicts.
  ══════════════════════════════════════════════════════════ */

  /* ══════════════════════════════════════════════════════════
     NEWSLETTER
  ══════════════════════════════════════════════════════════ */
  $(document).on('submit', '#svNewsletterForm', function (e) {
    e.preventDefault();
    $.post('/newsletter', { _token: CSRF, email: $(this).find('input[name=email]').val() })
      .done(d => { svToast(d.message, 'success'); $(this).find('input').val(''); })
      .fail(() => svToast('Error. Please try again.', 'error'));
  });

  // Announcement close
  $(document).on('click', '.sv-ann-close', function () { $(this).closest('.sv-announcement').slideUp(200); });

  // Admin sidebar
  window.svToggleSidebar = () => $('.sv-sidebar').toggleClass('open');

  // Variant accordion (admin)
  $(document).on('click', '.variant-card-header', function () {
    $(this).next('.variant-card-body').slideToggle(200);
    $(this).find('.vp-toggle').toggleClass('bi-chevron-down bi-chevron-up');
  });

  /* ══════════════════════════════════════════════════════════
     COUPON
  ══════════════════════════════════════════════════════════ */
  $(document).on('click', '#svApplyCoupon', function () {
    const code = $('#svCouponCode').val().trim();
    if (!code) return;
    $.post('/cart/coupon', { _token: CSRF, code })
      .done(d => {
        if (d.success) {
          $('#svCouponMsg').text(d.message).css('color', '#27ae60');
          $('#svDiscountRow').show().find('.sv-disc-val').text('-' + d.discount);
        } else {
          $('#svCouponMsg').text(d.message).css('color', '#e74c3c');
        }
      });
  });

  /* ══════════════════════════════════════════════════════════
     VARIANT MEDIA MANAGER MODAL (VMM)
     Fully featured: drag-drop, XHR upload to S3, set primary,
     delete, count badge, "how this works" info box
  ══════════════════════════════════════════════════════════ */
  let _vmmVid  = null;
  let _vmmName = '';

  window.svOpenVMM = function (variantId, variantName) {
    _vmmVid  = variantId;
    _vmmName = variantName || '';
    if ($('#svVMM').length) return;

    $('body').append(`
      <div class="sv-vmm-backdrop" id="svVMM">
        <div class="sv-vmm-box">
          <div class="sv-vmm-header">
            <div>
              <div class="sv-vmm-title">Variant Media Manager</div>
              <div class="sv-vmm-subtitle">${_vmmName}</div>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
              <span class="sv-vmm-count" id="svVMMCount">…</span>
              <button class="sv-vmm-close" onclick="svCloseVMM()"><i class="bi bi-x-lg"></i></button>
            </div>
          </div>
          <div class="sv-vmm-body">
            <div class="sv-vmm-dropzone" id="svVMMDrop">
              <span class="sv-vmm-dropzone-icon">📷</span>
              <div class="sv-vmm-dropzone-text">Drag &amp; drop images here, or click to browse</div>
              <div class="sv-vmm-dropzone-sub">JPG, PNG, WEBP, GIF — max 10MB each</div>
            </div>
            <div class="sv-vmm-actions">
              <label class="sv-vmm-btn sv-vmm-btn-img" style="cursor:pointer">
                <i class="bi bi-image"></i> Add Images
                <input type="file" accept="image/*" multiple style="display:none" onchange="svVMMUpload(this.files)">
              </label>
              <label class="sv-vmm-btn sv-vmm-btn-vid" style="cursor:pointer">
                <i class="bi bi-camera-video"></i> Add Video
                <input type="file" accept="video/*" style="display:none" onchange="svVMMUpload(this.files)">
              </label>
              <span style="font-size:11px;color:#444;align-self:center;margin-left:4px">Video: MP4/MOV up to 200MB</span>
            </div>
            <div class="sv-vmm-info">
              💡 <strong>How this works:</strong> When a customer selects this variant on the product page,
              the gallery <strong>automatically switches</strong> to show these images. Click ⭐ <strong>Set Primary</strong>
              to choose which image appears first. If no images are added here, the product's main gallery is shown instead.
            </div>
            <div class="sv-vmm-section-label">Uploaded Media — hover to set primary or delete</div>
            <div class="sv-vmm-grid" id="svVMMGrid">
              <div class="sv-vmm-empty"><i class="bi bi-cloud-arrow-up" style="font-size:2rem;opacity:.3;display:block;margin-bottom:8px"></i>Loading…</div>
            </div>
          </div>
        </div>
      </div>`);

    $('body').css('overflow', 'hidden');
    _vmmLoad();
    _vmmBindDrop();
  };

  window.svCloseVMM = function () {
    $('#svVMM').remove();
    $('body').css('overflow', '');
  };

  function _vmmLoad() {
    $.get(`/admin/products/variants/${_vmmVid}/media-list`)
      .done(d => {
        const list = d.media || [];
        $('#svVMMCount').text(list.length + ' files');
        _vmmRender(list);
      })
      .fail(() => {
        $('#svVMMGrid').html('<div class="sv-vmm-empty" style="color:#e74c3c">Failed to load media</div>');
      });
  }

  function _vmmRender(list) {
    if (!list.length) {
      $('#svVMMGrid').html('<div class="sv-vmm-empty"><i class="bi bi-images" style="font-size:2.5rem;opacity:.2;display:block;margin-bottom:10px"></i>No media yet — upload images or videos above.</div>');
      return;
    }
    $('#svVMMGrid').html(list.map(_vmmItem).join(''));
  }

  function _vmmItem(m) {
    const pb  = m.is_primary ? `<span class="sv-vmm-badge sv-vmm-badge-primary" style="position:absolute;top:7px;left:7px">⭐ PRIMARY</span>` : '';
    const vb  = m.type === 'video' ? `<span class="sv-vmm-badge sv-vmm-badge-video" style="position:absolute;top:7px;right:7px">VIDEO</span>` : '';
    const med = m.type === 'video'
      ? `<video src="${m.url}" style="width:100%;height:100%;object-fit:cover;pointer-events:none"></video>`
      : `<img src="${m.url}" alt="" onerror="this.src='/images/placeholder.svg'" style="width:100%;height:100%;object-fit:cover;pointer-events:none">`;
    const star = !m.is_primary ? `<button class="sv-vmm-item-btn sv-vmm-item-btn-star" onclick="svVMMPrimary(${m.id})">⭐ Main</button>` : '';
    return `<div class="sv-vmm-item${m.is_primary ? ' is-primary' : ''}" id="svVI_${m.id}">
      ${med}${pb}${vb}
      <div class="sv-vmm-item-overlay">
        <div></div>
        <div class="sv-vmm-item-actions">
          ${star}
          <button class="sv-vmm-item-btn sv-vmm-item-btn-del" onclick="svVMMDelete(${m.id})">🗑 Del</button>
        </div>
      </div>
    </div>`;
  }

  window.svVMMUpload = function (files) {
    Array.from(files).forEach(file => {
      const tmpId = 'sv_tmp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
      const $card = $(`
        <div class="sv-vmm-item" id="${tmpId}">
          <div class="sv-vmm-progress">
            <div class="sv-vmm-pct">0%</div>
            <div class="sv-vmm-bar"><div class="sv-vmm-bar-fill" style="width:0%"></div></div>
            <div style="font-size:10px;color:#555;margin-top:4px;max-width:110px;text-align:center;word-break:break-all">${file.name.substring(0, 22)}</div>
          </div>
        </div>`);

      // Remove empty state
      $('#svVMMGrid .sv-vmm-empty').remove();
      if (!$('#svVMMGrid').children().length) {
        $('#svVMMGrid').empty();
      }
      $('#svVMMGrid').prepend($card);

      const fd = new FormData();
      fd.append('file', file);
      fd.append('_token', CSRF);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', `/admin/products/variants/${_vmmVid}/media`);

      xhr.upload.onprogress = e => {
        if (e.lengthComputable) {
          const pct = Math.round(e.loaded / e.total * 100);
          $card.find('.sv-vmm-pct').text(pct + '%');
          $card.find('.sv-vmm-bar-fill').css('width', pct + '%');
        }
      };

      xhr.onload = () => {
        let r;
        try { r = JSON.parse(xhr.responseText); } catch (e) { r = null; }
        if (r && r.success) {
          $card.replaceWith($(_vmmItem(r.media)));
          const cnt = $('#svVMMGrid .sv-vmm-item').length;
          $('#svVMMCount').text(cnt + ' files');
          // Update inline grid on product page
          _refreshAdminGrid(r.media);
          svToast('Uploaded to S3!', 'success');
        } else {
          $card.remove();
          svToast((r && r.message) || 'Upload failed', 'error');
        }
      };

      xhr.onerror = () => { $card.remove(); svToast('Network error', 'error'); };
      xhr.send(fd);
    });
  };

  window.svVMMPrimary = function (mediaId) {
    $.post(`/admin/products/variants/media/${mediaId}/primary`, { _token: CSRF })
      .done(d => { if (d.success) { _vmmLoad(); svToast('Set as primary!', 'success'); } });
  };

  window.svVMMDelete = function (mediaId) {
    if (!confirm('Delete this media file?')) return;
    $.ajax({ url: `/admin/products/variants/media/${mediaId}`, method: 'DELETE', data: { _token: CSRF } })
      .done(d => {
        if (d.success) {
          $(`#svVI_${mediaId}`).remove();
          const cnt = $('#svVMMGrid .sv-vmm-item').length;
          $('#svVMMCount').text(cnt + ' files');
          if (!cnt) _vmmRender([]);
          $(`#svMc_${mediaId}`).remove();
          svToast('Deleted', 'success');
        }
      });
  };

  function _vmmBindDrop() {
    const $z = $('#svVMMDrop');
    $z.on('dragover',  e => { e.preventDefault(); $z.addClass('drag-over'); })
      .on('dragleave', () => $z.removeClass('drag-over'))
      .on('drop', e => {
        e.preventDefault(); $z.removeClass('drag-over');
        svVMMUpload(e.originalEvent.dataTransfer.files);
      })
      .on('click', () => {
        const $inp = $('<input type="file" accept="image/*,video/*" multiple style="display:none">');
        $inp.on('change', function () { svVMMUpload(this.files); });
        $('body').append($inp); $inp.trigger('click');
        setTimeout(() => $inp.remove(), 30000);
      });
  }

  function _refreshAdminGrid(m) {
    const $g = $(`#variantMedia_${_vmmVid}`);
    if (!$g.length) return;
    const isPrimary = !$g.find('.sv-primary-badge').length;
    const badge = isPrimary ? '<span class="sv-primary-badge">MAIN</span>' : '';
    const media = m.type === 'video'
      ? `<video src="${m.url}" style="width:100%;height:100%;object-fit:cover;pointer-events:none"></video><span class="sv-video-badge">VIDEO</span>`
      : `<img src="${m.url}" alt="" onerror="this.src='/images/placeholder.svg'">`;
    const starBtn = isPrimary ? '' : `<button class="sv-mt-btn sv-mt-primary" onclick="svSetPrimary(${m.id},${_vmmVid})">Main</button>`;
    $g.append(`<div class="sv-media-thumb${isPrimary ? ' is-primary' : ''}" id="svMc_${m.id}">
      ${media}${badge}
      <div class="sv-thumb-overlay"><div style="display:flex;gap:3px">
        ${starBtn}<button class="sv-mt-btn sv-mt-delete" onclick="svDeleteMedia(${m.id},${_vmmVid})">Del</button>
      </div></div>
    </div>`);
    // Update media button count
    const cnt = $g.find('.sv-media-thumb').length;
    $(`#vc_${_vmmVid} .sv-vmm-media-btn`).text(`📷 ${cnt} Media`).removeClass('btn-warning').addClass('btn-success');
  }

  /* ══════════════════════════════════════════════════════════
     INLINE ADMIN GRID — Upload / Set Primary / Delete
  ══════════════════════════════════════════════════════════ */
  window.svUploadVariantMedia = function (files, variantId) {
    Array.from(files).forEach(file => {
      const $c = $(`<div class="sv-media-thumb">
        <div class="sv-upload-progress-wrap">
          <div class="sv-upload-pct">0%</div>
          <div class="sv-upload-bar"><div class="sv-upload-fill" style="width:0%"></div></div>
        </div></div>`);
      $(`#variantMedia_${variantId}`).append($c);
      const fd = new FormData(); fd.append('file', file); fd.append('_token', CSRF);
      const xhr = new XMLHttpRequest();
      xhr.open('POST', `/admin/products/variants/${variantId}/media`);
      xhr.upload.onprogress = e => {
        if (e.lengthComputable) { const p = Math.round(e.loaded / e.total * 100); $c.find('.sv-upload-pct').text(p + '%'); $c.find('.sv-upload-fill').css('width', p + '%'); }
      };
      xhr.onload = () => {
        let r; try { r = JSON.parse(xhr.responseText); } catch (e) { r = null; }
        if (r && r.success) { $c.replaceWith($(_buildInlineThumb(r.media, variantId))); svToast('Uploaded!', 'success'); }
        else { $c.remove(); svToast((r && r.message) || 'Upload failed', 'error'); }
      };
      xhr.onerror = () => { $c.remove(); svToast('Network error', 'error'); };
      xhr.send(fd);
    });
  };

  function _buildInlineThumb(m, vid) {
    const media = m.type === 'video'
      ? `<video src="${m.url}" style="width:100%;height:100%;object-fit:cover;pointer-events:none"></video><span class="sv-video-badge">VIDEO</span>`
      : `<img src="${m.url}" alt="" onerror="this.src='/images/placeholder.svg'">`;
    const badge  = m.is_primary ? '<span class="sv-primary-badge">MAIN</span>' : '';
    const starBtn = !m.is_primary ? `<button class="sv-mt-btn sv-mt-primary" onclick="svSetPrimary(${m.id},${vid})">Main</button>` : '';
    return `<div class="sv-media-thumb${m.is_primary ? ' is-primary' : ''}" id="svMc_${m.id}">
      ${media}${badge}
      <div class="sv-thumb-overlay"><div style="display:flex;gap:3px">
        ${starBtn}<button class="sv-mt-btn sv-mt-delete" onclick="svDeleteMedia(${m.id},${vid})">Del</button>
      </div></div>
    </div>`;
  }

  window.svSetPrimary = function (mediaId, variantId) {
    $.post(`/admin/products/variants/media/${mediaId}/primary`, { _token: CSRF })
      .done(d => {
        if (d.success) {
          $(`#variantMedia_${variantId} .sv-media-thumb`).removeClass('is-primary').find('.sv-primary-badge').remove();
          $(`#svMc_${mediaId}`).addClass('is-primary').prepend('<span class="sv-primary-badge">MAIN</span>');
          svToast('Set as main image!', 'success');
        }
      });
  };

  window.svDeleteMedia = function (mediaId, variantId) {
    if (!confirm('Delete this file?')) return;
    $.ajax({ url: `/admin/products/variants/media/${mediaId}`, method: 'DELETE', data: { _token: CSRF } })
      .done(d => { if (d.success) { $(`#svMc_${mediaId}`).remove(); svToast('Deleted', 'success'); } });
  };

  /* ══════════════════════════════════════════════════════════
     PRODUCT COVER UPLOAD
  ══════════════════════════════════════════════════════════ */
  window.svUploadCover = function (files, pid) {
    if (!files.length) return;
    svToast('Uploading cover to S3…', 'info');
    const fd = new FormData(); fd.append('file', files[0]); fd.append('_token', CSRF);
    $.ajax({ url: `/admin/products/${pid}/cover`, method: 'POST', data: fd, processData: false, contentType: false })
      .done(d => {
        if (d.success) { $('#svCoverPreview').attr('src', d.url).show(); $('#svCoverUrl').text(d.url); svToast('Cover uploaded!', 'success'); }
        else svToast(d.message || 'Upload failed', 'error');
      });
  };

})(jQuery);
