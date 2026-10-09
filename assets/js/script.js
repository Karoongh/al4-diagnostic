(function () {
  'use strict';

  function goTab(id) {
    document.querySelectorAll('.al4-panel').forEach(function (p) { p.classList.remove('active'); });
    document.querySelectorAll('.al4-tab').forEach(function (t) { t.classList.remove('active'); });
    var panel = document.getElementById(id);
    if (panel) panel.classList.add('active');
    var btn = document.querySelector('.al4-tab[data-tab="' + id + '"]');
    if (btn) btn.classList.add('active');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function checked(containerId) {
    var el = document.getElementById(containerId);
    if (!el) return [];
    return Array.prototype.slice.call(el.querySelectorAll('input:checked')).map(function (c) { return c.value; });
  }

  function val(id) {
    var el = document.getElementById(id);
    return el ? el.value : '';
  }

  function esc(t) {
    if (!t) return '';
    var d = document.createElement('div');
    d.textContent = t;
    return d.innerHTML;
  }

  function renderResult(data) {
    var html = '';
    html += '<div class="al4-verdict ' + esc(data.vclass) + '"><h3>' + esc(data.verdict) + '</h3>';
    html += '<div class="conf">سطح اطمینان: <strong>' + esc(data.confidence) + '</strong></div></div>';

    if (data.warnings && data.warnings.length) {
      html += '<div class="al4-block"><h4>⚠️ هشدارها</h4>';
      data.warnings.forEach(function (w) {
        html += '<div class="al4-issue medium"><div class="d">' + esc(w) + '</div></div>';
      });
      html += '</div>';
    }

    if (data.issues && data.issues.length) {
      html += '<div class="al4-block"><h4>🔍 مشکلات تشخیص‌داده‌شده</h4>';
      data.issues.forEach(function (i) {
        html += '<div class="al4-issue ' + esc(i.sev) + '"><div class="t">' + esc(i.title) + '</div><div class="d">' + esc(i.desc) + '</div></div>';
      });
      html += '</div>';
    }

    if (data.steps && data.steps.length) {
      html += '<div class="al4-block"><h4>📋 مراحل پیشنهادی (از ساده به پیچیده)</h4><div class="al4-steps">';
      data.steps.forEach(function (s) {
        html += '<div class="al4-step">' + esc(s) + '</div>';
      });
      html += '</div></div>';
    }

    if (data.code_meanings && Object.keys(data.code_meanings).length) {
      html += '<div class="al4-block"><h4>📖 معنی کدهای انتخاب‌شده</h4>';
      Object.keys(data.code_meanings).forEach(function (c) {
        html += '<div style="margin-bottom:6px;font-size:.88rem"><span class="al4-tag">' + esc(c) + '</span> ' + esc(data.code_meanings[c]) + '</div>';
      });
      html += '</div>';
    }

    html += '<div class="al4-block" style="font-size:.85rem;color:#64748b"><strong>توجه:</strong> این ابزار راهنماست. جای دستگاه دیاگ و دفترچه تعمیرات همان مدل را نمی‌گیرد.</div>';

    var area = document.getElementById('al4-result');
    area.innerHTML = html;
    area.classList.add('show');
    goTab('t5');
  }

  function runDiag() {
    var data = {
      action: 'al4_diagnose',
      nonce: (typeof al4_ajax !== 'undefined') ? al4_ajax.nonce : '',
      model: val('model'),
      prechecks: checked('prechecks'),
      codes: checked('error_codes'),
      symptoms: checked('symptoms'),
      oil_temp: val('oil_temp'),
      battery: val('battery'),
      res_evm: val('res_evm'),
      res_evlu: val('res_evlu'),
      res_evs: val('res_evs'),
      res_flow: val('res_flow'),
      press_compare: val('press_compare'),
      press_stable: val('press_stable'),
      stall: val('stall')
    };

    var btn = document.getElementById('al4-run-btn');
    if (btn) {
      btn.disabled = true;
      btn.textContent = 'در حال تحلیل...';
    }

    var body = new URLSearchParams();
    Object.keys(data).forEach(function (k) {
      if (Array.isArray(data[k])) {
        data[k].forEach(function (v) { body.append(k + '[]', v); });
      } else {
        body.append(k, data[k]);
      }
    });

    fetch(al4_ajax.ajax_url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString()
    })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res.success) {
          renderResult(res.data);
        } else {
          alert('خطا در پردازش. دوباره تلاش کنید.');
        }
      })
      .catch(function () {
        alert('خطای ارتباط با سرور.');
      })
      .finally(function () {
        if (btn) {
          btn.disabled = false;
          btn.textContent = 'شروع تشخیص هوشمند';
        }
      });
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.al4-tab').forEach(function (t) {
      t.addEventListener('click', function () { goTab(t.getAttribute('data-tab')); });
    });

    document.querySelectorAll('[data-goto]').forEach(function (b) {
      b.addEventListener('click', function () { goTab(b.getAttribute('data-goto')); });
    });

    var runBtn = document.getElementById('al4-run-btn');
    if (runBtn) runBtn.addEventListener('click', runDiag);

    var resetBtn = document.getElementById('al4-reset-btn');
    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        document.querySelectorAll('.al4-wrap input[type=checkbox]').forEach(function (c) { c.checked = false; });
        document.querySelectorAll('.al4-wrap select').forEach(function (s) { s.selectedIndex = 0; });
        var area = document.getElementById('al4-result');
        if (area) { area.innerHTML = ''; area.classList.remove('show'); }
        goTab('t1');
      });
    }

    document.querySelectorAll('.al4-acc-head').forEach(function (h) {
      h.addEventListener('click', function () {
        h.classList.toggle('open');
        var body = h.nextElementSibling;
        if (body) body.classList.toggle('open');
      });
    });
  });
})();
