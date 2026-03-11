import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// New dashboard functionality
const mainBalanceEl = document.getElementById('mainBalance');
let mainBalance = 1200;

function setMainBalance(value) {
  mainBalance = value;
  mainBalanceEl.textContent = `$${value.toFixed(2)}`;
}

// Sidebar navigation: Dashboard vs My Cards vs Add Money vs API Docs vs Get API
const navDashboard = document.getElementById('navDashboard');
const navMyCards = document.getElementById('navMyCards');
const navAddMoney = document.getElementById('navAddMoney');
const navApiDocs = document.getElementById('navApiDocs');
const navGetApi = document.getElementById('navGetApi');
const navNotifications = document.getElementById('navNotifications');
const navSettings = document.getElementById('navSettings');
const viewDashboard = document.getElementById('viewDashboard');
const viewMyCards = document.getElementById('viewMyCards');
const viewAddMoney = document.getElementById('viewAddMoney');
const viewApiDocs = document.getElementById('viewApiDocs');
const viewGetApi = document.getElementById('viewGetApi');
const viewNotifications = document.getElementById('viewNotifications');
const viewSettings = document.getElementById('viewSettings');

function loadProfileFromStorage() {
  try {
    var raw = localStorage.getItem('virtualpayProfile');
    if (!raw) return;
    var p = JSON.parse(raw);
    var elName = document.getElementById('profileFullName');
    var elEmail = document.getElementById('profileEmail');
    var elCountry = document.getElementById('profileCountry');
    var elPhone = document.getElementById('profilePhone');
    if (elName && p.name) elName.value = p.name;
    if (elEmail && p.email) elEmail.value = p.email;
    if (elCountry && p.country) elCountry.value = p.country;
    if (elPhone && p.phone) elPhone.value = p.phone;
  } catch (err) { }
}
loadProfileFromStorage();

function resetAllNav() {
  var navs = [navDashboard, navMyCards, navAddMoney, navApiDocs, navGetApi, navNotifications, navSettings];
  navs.forEach(function (n) {
    if (!n) return;
    n.classList.remove('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100', 'bg-violet-50', 'text-violet-700', 'border-violet-100');
    n.classList.add('text-slate-600');
  });
  [viewDashboard, viewMyCards, viewAddMoney, viewApiDocs, viewGetApi, viewNotifications, viewSettings].forEach(function (v) { if (v) v.classList.add('hidden'); });
}

function activateDashboard() {
  resetAllNav();
  viewDashboard.classList.remove('hidden');
  navDashboard.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100');
}

function activateMyCards() {
  resetAllNav();
  viewMyCards.classList.remove('hidden');
  navMyCards.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100');
}

function activateAddMoney() {
  resetAllNav();
  viewAddMoney.classList.remove('hidden');
  navAddMoney.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100');
}

function activateApiDocs() {
  resetAllNav();
  viewApiDocs.classList.remove('hidden');
  navApiDocs.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100');
}

function activateGetApi() {
  resetAllNav();
  viewGetApi.classList.remove('hidden');
  navGetApi.classList.add('bg-violet-50', 'text-violet-700', 'border', 'border-violet-100');
}

function activateSettings() {
  resetAllNav();
  loadProfileFromStorage();
  viewSettings.classList.remove('hidden');
  navSettings.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100');
}

function activateNotifications() {
  resetAllNav();
  viewNotifications.classList.remove('hidden');
  navNotifications.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-100');
}

const btnNotifications = document.getElementById('btnNotifications');
const notificationPanel = document.getElementById('notificationPanel');
const notifBadge = document.getElementById('notifBadge');
const notifMarkRead = document.getElementById('notifMarkRead');
const notifViewAll = document.getElementById('notifViewAll');

btnNotifications?.addEventListener('click', (e) => {
  e.stopPropagation();
  notificationPanel.classList.toggle('hidden');
});
document.addEventListener('click', () => notificationPanel.classList.add('hidden'));
notificationPanel?.addEventListener('click', (e) => e.stopPropagation());

notifMarkRead?.addEventListener('click', (e) => {
  e.preventDefault();
  document.querySelectorAll('.notif-unread-dot').forEach(d => d.classList.add('hidden'));
  notifBadge.classList.add('hidden');
  notifBadge.textContent = '0';
});
notifViewAll?.addEventListener('click', (e) => {
  e.preventDefault();
  notificationPanel.classList.add('hidden');
  activateNotifications();
});

document.querySelectorAll('.notif-item').forEach(el => {
  el.addEventListener('click', (e) => {
    e.preventDefault();
    notificationPanel.classList.add('hidden');
    activateNotifications();
  });
});

document.getElementById('btnLogout')?.addEventListener('click', () => {
  if (confirm('Are you sure you want to log out?')) {
    alert('Demo: In production, user would be redirected to login page.');
    // window.location.href = '/login';
  }
});

document.getElementById('formChangePassword')?.addEventListener('submit', (e) => {
  e.preventDefault();
  const form = e.target;
  const newP = form.querySelector('[name="new"]').value;
  const confirmP = form.querySelector('[name="confirm"]').value;
  if (!newP || newP.length < 6) {
    alert('New password must be at least 6 characters.');
    return;
  }
  if (newP !== confirmP) {
    alert('New password and confirm password do not match.');
    return;
  }
  alert('Demo: Password would be updated. In production, send to your backend.');
  form.reset();
});

navDashboard.addEventListener('click', activateDashboard);
navMyCards.addEventListener('click', activateMyCards);
navAddMoney.addEventListener('click', activateAddMoney);
navApiDocs.addEventListener('click', activateApiDocs);
navGetApi.addEventListener('click', activateGetApi);
navNotifications.addEventListener('click', activateNotifications);
navSettings.addEventListener('click', activateSettings);

const notificationDetailModal = document.getElementById('notificationDetailModal');
const closeNotificationDetail = document.getElementById('closeNotificationDetail');
const closeNotificationDetailBtn = document.getElementById('closeNotificationDetailBtn');
function openNotificationDetail(type, amount, merchant, card, time) {
  document.getElementById('detailType').textContent = type === 'topup' ? 'Top-up' : 'Card payment';
  document.getElementById('detailAmount').textContent = type === 'topup' ? '+' + '$' + amount : '-$' + amount;
  document.getElementById('detailAmount').className = type === 'topup' ? 'font-semibold text-sky-600' : 'font-semibold text-slate-800';
  document.getElementById('detailMerchant').textContent = merchant || '—';
  document.getElementById('detailCard').textContent = card || '—';
  document.getElementById('detailTime').textContent = time || '—';
  notificationDetailModal.classList.remove('hidden');
  notificationDetailModal.classList.add('flex');
}
function closeNotificationDetailModal() {
  notificationDetailModal.classList.add('hidden');
  notificationDetailModal.classList.remove('flex');
}
document.querySelectorAll('.notif-history-item').forEach(btn => {
  btn.addEventListener('click', () => {
    const d = btn.dataset;
    openNotificationDetail(d.type, d.amount, d.merchant, d.card, d.time);
  });
});
closeNotificationDetail?.addEventListener('click', closeNotificationDetailModal);
closeNotificationDetailBtn?.addEventListener('click', closeNotificationDetailModal);
notificationDetailModal?.addEventListener('click', (e) => { if (e.target === notificationDetailModal) closeNotificationDetailModal(); });

var apiSuccessModal = document.getElementById('apiSuccessModal');
var apiBaseUrlEl = document.getElementById('apiBaseUrl');
var apiKeyDisplayEl = document.getElementById('apiKeyDisplay');
var API_BASE_URL = 'https://api.virtualpay.example.com/v1';

function openApiSuccessModal() {
  var newKey = 'vp_live_' + Math.random().toString(36).slice(2, 14) + '_' + Math.random().toString(36).slice(2, 10);
  apiKeyDisplayEl.textContent = newKey;
  apiKeyDisplayEl.dataset.key = newKey;
  apiBaseUrlEl.textContent = API_BASE_URL;
  apiSuccessModal.classList.remove('hidden');
  apiSuccessModal.classList.add('flex');
}
function closeApiSuccessModal() {
  apiSuccessModal.classList.add('hidden');
  apiSuccessModal.classList.remove('flex');
}
document.getElementById('closeApiSuccess')?.addEventListener('click', closeApiSuccessModal);
document.getElementById('closeApiSuccessBtn')?.addEventListener('click', closeApiSuccessModal);
apiSuccessModal?.addEventListener('click', function (e) { if (e.target === apiSuccessModal) closeApiSuccessModal(); });
document.getElementById('copyApiUrl')?.addEventListener('click', function () {
  navigator.clipboard.writeText(API_BASE_URL).then(() => { this.textContent = 'Copied!'; var t = this; setTimeout(() => t.textContent = 'Copy', 1500); });
});
document.getElementById('copyApiKey')?.addEventListener('click', function () {
  var key = document.getElementById('apiKeyDisplay').textContent || '';
  navigator.clipboard.writeText(key).then(() => { this.textContent = 'Copied!'; var t = this; setTimeout(() => t.textContent = 'Copy', 1500); });
});

document.getElementById('btnBuyApi')?.addEventListener('click', () => {
  if (mainBalance < 300) {
    alert('Insufficient balance. You need $300 in your main balance to buy API access.');
    return;
  }
  openProcessing();
  processingModal.querySelector('h4').textContent = 'Processing payment...';
  processingModal.querySelector('p').textContent = 'Deducting $300 from your balance for API access.';
  setTimeout(() => {
    closeProcessing();
    setMainBalance(mainBalance - 300);
    openApiSuccessModal();
    processingModal.querySelector('h4').textContent = 'Processing your order';
    processingModal.querySelector('p').textContent = 'Please wait a moment. We are creating your virtual card securely.';
  }, 1200);
});

const tabOnetime = document.getElementById('tabOnetime');
const tabReloadable = document.getElementById('tabReloadable');
const panelOnetime = document.getElementById('panelOnetime');
const panelReloadable = document.getElementById('panelReloadable');

tabOnetime.addEventListener('click', () => {
  tabOnetime.classList.add('border-emerald-500', 'text-emerald-600', 'bg-white');
  tabReloadable.classList.remove('border-emerald-500', 'text-emerald-600', 'bg-white');
  tabReloadable.classList.add('text-slate-500');
  panelOnetime.classList.remove('hidden');
  panelReloadable.classList.add('hidden');
});

tabReloadable.addEventListener('click', () => {
  tabReloadable.classList.add('border-emerald-500', 'text-emerald-600', 'bg-white');
  tabOnetime.classList.remove('border-emerald-500', 'text-emerald-600', 'bg-white');
  tabOnetime.classList.add('text-slate-500');
  panelReloadable.classList.remove('hidden');
  panelOnetime.classList.add('hidden');
});

const onetimeOptions = document.querySelectorAll('.card-option-onetime');
const onetimeSummaryBin = document.getElementById('onetimeSummaryBin');
let selectedOnetime = 'classic';
let selectedOnetimeBin = '537100';

onetimeOptions.forEach(btn => {
  btn.addEventListener('click', () => {
    onetimeOptions.forEach(b =>
      b.classList.remove('border-emerald-400', 'bg-emerald-50', 'border-emerald-500')
    );
    btn.classList.add('border-emerald-500', 'bg-emerald-50');
    selectedOnetime = btn.dataset.onetimeCard;
    selectedOnetimeBin = btn.dataset.onetimeBin || '537100';
    if (onetimeSummaryBin) onetimeSummaryBin.textContent = selectedOnetimeBin;
  });
});

const reloadSummaryDesign = document.getElementById('reloadSummaryDesign');
const reloadEmailInput = document.getElementById('reloadEmail');

var ONETIME_CARD_COST = 1;
var ONETIME_FEE_PERCENT = 2;
var RELOAD_CARD_COST = 1;
var RELOAD_FEE_PERCENT = 2;

function updateOnetimeSummary() {
  var amount = parseFloat(onetimeAmountInput.value || '0') || 0;
  var cardCost = ONETIME_CARD_COST;
  var fee = Math.round(amount * ONETIME_FEE_PERCENT) / 100;
  var total = cardCost + amount + fee;
  var elAmount = document.getElementById('onetimeSummaryAmount');
  var elCardCost = document.getElementById('onetimeSummaryCardCost');
  var elFee = document.getElementById('onetimeSummaryFee');
  var elTotal = document.getElementById('onetimeSummaryTotal');
  if (elAmount) elAmount.textContent = '$' + amount.toFixed(2);
  if (elCardCost) elCardCost.textContent = '$' + cardCost.toFixed(2);
  if (elFee) elFee.textContent = '$' + fee.toFixed(2);
  if (elTotal) elTotal.textContent = '$' + total.toFixed(2);
}

function updateReloadSummary() {
  var amount = parseFloat(reloadAmountInput.value || '0') || 0;
  var cardCost = RELOAD_CARD_COST;
  var fee = Math.round(amount * RELOAD_FEE_PERCENT) / 100;
  var total = cardCost + amount + fee;
  var elAmount = document.getElementById('reloadSummaryAmount');
  var elCardCost = document.getElementById('reloadSummaryCardCost');
  var elFee = document.getElementById('reloadSummaryFee');
  var elTotal = document.getElementById('reloadSummaryTotal');
  if (elAmount) elAmount.textContent = '$' + amount.toFixed(2);
  if (elCardCost) elCardCost.textContent = '$' + cardCost.toFixed(2);
  if (elFee) elFee.textContent = '$' + fee.toFixed(2);
  if (elTotal) elTotal.textContent = '$' + total.toFixed(2);
}

function attachQuickAmount(selector, inputEl, afterChange) {
  document.querySelectorAll(selector).forEach(btn => {
    btn.addEventListener('click', () => {
      inputEl.value = btn.textContent.trim();
      if (afterChange) afterChange();
      else inputEl.dispatchEvent(new Event('input'));
    });
  });
}

const onetimeAmountInput = document.getElementById('onetimeAmount');
const reloadAmountInput = document.getElementById('reloadAmount');
attachQuickAmount('.quick-amount-onetime', onetimeAmountInput, updateOnetimeSummary);
attachQuickAmount('.quick-amount-reload', reloadAmountInput, updateReloadSummary);
onetimeAmountInput.addEventListener('input', updateOnetimeSummary);
reloadAmountInput.addEventListener('input', updateReloadSummary);
updateOnetimeSummary();
updateReloadSummary();

const processingModal = document.getElementById('processingModal');
const detailsModal = document.getElementById('detailsModal');
const closeDetails = document.getElementById('closeDetails');

function openProcessing() {
  processingModal.classList.remove('hidden');
  processingModal.classList.add('flex');
}
function closeProcessing() {
  processingModal.classList.add('hidden');
  processingModal.classList.remove('flex');
}
function openDetails() {
  detailsModal.classList.remove('hidden');
  detailsModal.classList.add('flex');
}
function closeDetailsModal() {
  detailsModal.classList.add('hidden');
  detailsModal.classList.remove('flex');
}
closeDetails.addEventListener('click', closeDetailsModal);
detailsModal.addEventListener('click', e => {
  if (e.target === detailsModal) closeDetailsModal();
});

function randomDigits(len) {
  let s = '';
  for (let i = 0; i < len; i++) s += Math.floor(Math.random() * 10);
  return s;
}

function fillDetails({ type, amount }) {
  const detailsTag = document.getElementById('detailsTag');
  const detailsType = document.getElementById('detailsType');
  const detailsNumber = document.getElementById('detailsNumber');
  const detailsExpiry = document.getElementById('detailsExpiry');
  const detailsCvv = document.getElementById('detailsCvv');
  const detailsBalance = document.getElementById('detailsBalance');
  const btnTopupDetails = document.getElementById('btnTopupDetails');

  const cardNumber = `${randomDigits(4)} ${randomDigits(4)} ${randomDigits(4)} ${randomDigits(4)}`;
  var last4 = cardNumber.replace(/\s/g, '').slice(-4);
  detailsNumber.textContent = '• • • • • • • • • • • • ' + last4;
  detailsExpiry.textContent = '12/29';
  detailsCvv.textContent = randomDigits(3);
  detailsBalance.textContent = `$${(amount || 0).toFixed(2)}`;

  if (type === 'onetime') {
    detailsTag.textContent = 'NEW ONE‑TIME CARD';
    detailsType.textContent = 'ONE‑TIME CARD';
    btnTopupDetails.classList.add('opacity-40', 'cursor-not-allowed');
    btnTopupDetails.disabled = true;
  } else {
    detailsTag.textContent = 'NEW RELOADABLE CARD';
    detailsType.textContent = 'RELOADABLE CARD';
    btnTopupDetails.classList.remove('opacity-40', 'cursor-not-allowed');
    btnTopupDetails.disabled = false;
  }
  currentDetailsCardBalance = amount || 0;
  setModalFreezeState(false);
}

const btnOrderOnetime = document.getElementById('btnOrderOnetime');
const btnOrderReload = document.getElementById('btnOrderReload');

btnOrderOnetime.addEventListener('click', () => {
  var amount = parseFloat(onetimeAmountInput.value || '0') || 0;
  if (!amount || amount < 10) {
    alert('Minimum one‑time card amount is $10. Please enter a custom amount of at least $10.');
    return;
  }
  var cardCost = ONETIME_CARD_COST;
  var fee = Math.round(amount * ONETIME_FEE_PERCENT) / 100;
  var totalToPay = cardCost + amount + fee;
  if (totalToPay > mainBalance) {
    alert('Insufficient main balance. Total to pay (card cost + load amount + fee): $' + totalToPay.toFixed(2) + '.');
    return;
  }
  openProcessing();
  setTimeout(() => {
    closeProcessing();
    setMainBalance(mainBalance - totalToPay);
    fillDetails({ type: 'onetime', amount: amount });
    openDetails();
  }, 1200);
});

btnOrderReload.addEventListener('click', () => {
  var amount = parseFloat(reloadAmountInput.value || '0') || 0;
  if (!amount || amount < 10) {
    alert('Minimum reloadable card amount is $10.');
    return;
  }
  var cardCost = RELOAD_CARD_COST;
  var fee = Math.round(amount * RELOAD_FEE_PERCENT) / 100;
  var totalToPay = cardCost + amount + fee;
  if (totalToPay > mainBalance) {
    alert('Insufficient main balance. Total to pay (card cost + load amount + fee): $' + totalToPay.toFixed(2) + '.');
    return;
  }
  var email = (reloadEmailInput?.value || '').trim();
  if (!email) {
    alert('Please enter your email for 3D Secure OTP. OTP will be sent to this email when you pay with this card.');
    return;
  }
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    alert('Please enter a valid email address.');
    return;
  }
  openProcessing();
  setTimeout(function () {
    closeProcessing();
    setMainBalance(mainBalance - totalToPay);
    fillDetails({ type: 'reload', amount: amount });
    openDetails();
  }, 1200);
});

document.querySelectorAll('.btn-freeze').forEach(btn => {
  btn.addEventListener('click', () => {
    const row = btn.closest('.card-row');
    const isFrozen = row.classList.contains('opacity-70');
    if (isFrozen) {
      row.classList.remove('opacity-70');
      btn.textContent = 'Freeze';
    } else {
      row.classList.add('opacity-70');
      btn.textContent = 'Unfreeze';
    }
  });
});

document.querySelectorAll('.btn-topup').forEach(btn => {
  btn.addEventListener('click', () => {
    const amount = prompt('Top‑up amount (USD):', '50');
    const value = parseFloat(amount || '0');
    if (!value) return;
    if (value > mainBalance) {
      alert('Insufficient main balance.');
      return;
    }
    setMainBalance(mainBalance - value);
    alert(`Successfully topped‑up $${value.toFixed(2)} to this card (demo only).`);
  });
});

document.querySelectorAll('.btn-view-details').forEach(btn => {
  btn.addEventListener('click', () => {
    fillDetails({ type: 'reload', amount: 120 });
    openDetails();
  });
});

let detailsCardFrozen = false;
let selectedCardFrozen = false;
let currentDetailsCardBalance = 0;
var selectedCardBalanceValue = 230;

function setModalFreezeState(frozen) {
  detailsCardFrozen = frozen;
  const wrap = document.getElementById('detailsCardWrap');
  const statusEl = document.getElementById('detailsStatus');
  const btn = document.getElementById('btnFreezeToggle');
  if (wrap) wrap.classList.toggle('card-frozen', frozen);
  if (statusEl) {
    if (frozen) {
      statusEl.className = 'inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 border border-slate-300 text-[11px] text-slate-600';
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Frozen';
    } else {
      statusEl.className = 'inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 border border-emerald-200 text-emerald-700';
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active';
    }
  }
  if (btn) {
    btn.textContent = frozen ? 'Unfreeze card' : 'Freeze card';
    btn.classList.toggle('hover:border-amber-400/80', !frozen);
    btn.classList.toggle('hover:border-emerald-400/80', frozen);
    btn.classList.toggle('hover:text-amber-600', !frozen);
    btn.classList.toggle('hover:text-emerald-600', frozen);
  }
}

function setPanelFreezeState(frozen) {
  selectedCardFrozen = frozen;
  const box = document.getElementById('selectedCardBox');
  const statusEl = document.getElementById('selectedCardStatus');
  const btn = document.getElementById('btnFreezeSelectedCard');
  if (box) box.classList.toggle('card-frozen', frozen);
  if (statusEl) {
    if (frozen) {
      statusEl.className = 'inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-0.5 border border-slate-300 text-[11px] text-slate-600';
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Frozen';
    } else {
      statusEl.className = 'inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 border border-emerald-200 text-[11px] text-emerald-700';
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active';
    }
  }
  if (btn) btn.textContent = frozen ? 'Unfreeze card' : 'Freeze card';
}

const btnFreezeToggle = document.getElementById('btnFreezeToggle');
btnFreezeToggle.addEventListener('click', () => setModalFreezeState(!detailsCardFrozen));

document.getElementById('btnFreezeSelectedCard')?.addEventListener('click', () => setPanelFreezeState(!selectedCardFrozen));

var selectedCardClosed = false;
function setSelectedCardClosed(closed) {
  selectedCardClosed = closed;
  var statusEl = document.getElementById('selectedCardStatus');
  var btnFreeze = document.getElementById('btnFreezeSelectedCard');
  var btnTopup = document.getElementById('btnTopupSelectedCard');
  var btnClose = document.getElementById('btnCloseSelectedCard');
  var cardBox = document.getElementById('selectedCardBox');
  if (statusEl) {
    if (closed) {
      statusEl.className = 'inline-flex items-center gap-1 rounded-full bg-slate-100 dark:bg-slate-700 px-2 py-0.5 border border-slate-300 dark:border-slate-600 text-[11px] text-slate-600 dark:text-slate-400';
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Closed';
    } else {
      statusEl.className = 'inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 border border-emerald-200 dark:border-emerald-800 text-[11px] text-emerald-700 dark:text-emerald-400';
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active';
    }
  }
  if (btnFreeze) { btnFreeze.disabled = closed; btnFreeze.classList.toggle('opacity-50', closed); btnFreeze.classList.toggle('cursor-not-allowed', closed); }
  if (btnTopup) { btnTopup.disabled = closed; btnTopup.classList.toggle('opacity-50', closed); btnTopup.classList.toggle('cursor-not-allowed', closed); }
  if (btnClose) { btnClose.disabled = closed; btnClose.classList.toggle('opacity-50', closed); btnClose.classList.toggle('cursor-not-allowed', closed); }
  if (cardBox) cardBox.classList.toggle('opacity-75', closed);
}

document.getElementById('btnCloseSelectedCard')?.addEventListener('click', function () {
  if (selectedCardClosed) return;
  if (!confirm('Are you sure you want to close this card? It cannot be used for new transactions.')) return;
  setSelectedCardClosed(true);
  var detailsModal = document.getElementById('detailsModal');
  if (detailsModal && !detailsModal.classList.contains('hidden')) detailsModal.classList.add('hidden'), detailsModal.classList.remove('flex');
});

document.getElementById('btnCloseCardDetails')?.addEventListener('click', function () {
  if (selectedCardClosed) return;
  if (!confirm('Are you sure you want to close this card? It cannot be used for new transactions.')) return;
  setSelectedCardClosed(true);
  var detailsModal = document.getElementById('detailsModal');
  if (detailsModal) detailsModal.classList.add('hidden'), detailsModal.classList.remove('flex');
});

const topupModal = document.getElementById('topupModal');
const topupAmountInput = document.getElementById('topupAmountInput');
const topupToCardEl = document.getElementById('topupToCard');
const topupFeeEl = document.getElementById('topupFee');
const topupTotalEl = document.getElementById('topupTotal');
const closeTopupModal = document.getElementById('closeTopupModal');
const confirmTopup = document.getElementById('confirmTopup');
const TOPUP_FEE_PERCENT = 10;
let topupTarget = 'details';

function openTopupModal(target) {
  topupTarget = target || 'details';
  topupAmountInput.value = '';
  topupToCardEl.textContent = '$0.00';
  topupFeeEl.textContent = '$0.00';
  topupTotalEl.textContent = '$0.00';
  topupModal.classList.remove('hidden');
  topupModal.classList.add('flex');
  topupAmountInput.focus();
}

function closeTopupModalFn() {
  topupModal.classList.add('hidden');
  topupModal.classList.remove('flex');
}

function updateTopupSummary() {
  const amount = parseFloat(topupAmountInput.value || '0') || 0;
  const fee = Math.round(amount * TOPUP_FEE_PERCENT) / 100;
  const total = amount + fee;
  topupToCardEl.textContent = '$' + amount.toFixed(2);
  topupFeeEl.textContent = '$' + fee.toFixed(2);
  topupTotalEl.textContent = '$' + total.toFixed(2);
}

topupAmountInput.addEventListener('input', updateTopupSummary);

closeTopupModal?.addEventListener('click', closeTopupModalFn);
topupModal?.addEventListener('click', (e) => { if (e.target === topupModal) closeTopupModalFn(); });

confirmTopup?.addEventListener('click', () => {
  const amount = parseFloat(topupAmountInput.value || '0') || 0;
  if (amount < 1) {
    alert('Please enter at least $1 to top up.');
    return;
  }
  const fee = Math.round(amount * TOPUP_FEE_PERCENT) / 100;
  const total = amount + fee;
  if (total > mainBalance) {
    alert('Insufficient main balance. Total required (amount + 10% fee): $' + total.toFixed(2) + '.');
    return;
  }
  setMainBalance(mainBalance - total);
  if (topupTarget === 'details') {
    currentDetailsCardBalance += amount;
    const detailsBalance = document.getElementById('detailsBalance');
    if (detailsBalance) detailsBalance.textContent = '$' + currentDetailsCardBalance.toFixed(2);
  } else {
    selectedCardBalanceValue += amount;
    const selBal = document.getElementById('selectedCardBalance');
    if (selBal) selBal.textContent = '$' + selectedCardBalanceValue.toFixed(2);
  }
  closeTopupModalFn();
  alert('Top‑up successful. $' + amount.toFixed(2) + ' added to card. Fee (10%): $' + fee.toFixed(2) + ' (demo).');
});

document.getElementById('btnTopupDetails').addEventListener('click', () => {
  if (document.getElementById('btnTopupDetails').disabled) return;
  openTopupModal('details');
});
document.getElementById('btnTopupSelectedCard')?.addEventListener('click', () => openTopupModal('panel'));

function refreshBalanceDisplay(balanceEl, value, btn) {
  if (!balanceEl) return;
  if (btn) { btn.disabled = true; btn.classList.add('opacity-60'); }
  var originalText = balanceEl.textContent;
  balanceEl.textContent = '…';
  setTimeout(function () {
    balanceEl.textContent = '$' + (typeof value === 'number' ? value.toFixed(2) : value);
    if (btn) { btn.disabled = false; btn.classList.remove('opacity-60'); }
  }, 700);
}

document.getElementById('btnRefreshSelectedBalance')?.addEventListener('click', function () {
  refreshBalanceDisplay(document.getElementById('selectedCardBalance'), selectedCardBalanceValue, this);
});
document.getElementById('btnRefreshDetailsBalance')?.addEventListener('click', function () {
  refreshBalanceDisplay(document.getElementById('detailsBalance'), currentDetailsCardBalance, this);
});

// Dark / Light mode toggle
document.getElementById('themeToggle').addEventListener('click', function () {
  var html = document.documentElement;
  var isDark = html.classList.toggle('dark');
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
});