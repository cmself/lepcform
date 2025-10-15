<div class="flex flex-col md:flex-row items-center justify-center gap-[40px] w-full py-[20px]">

    <div class="item item-1 flex flex-row items-center justify-center gap-[10px] <?php if ($step == 1): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-center text-[var(--color-blanc)] text-[30px] font-bold">1</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium">Organisation signataire</span>
    </div>
    <div class="item item-2 flex flex-row items-center justify-center gap-[10px]  <?php if ($step == 2 || $step == 3): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-center text-[var(--color-blanc)] text-[30px] font-bold">2</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium">Interlocuteurs</span>
    </div>
    <div class="item item-3 flex flex-row items-center justify-center gap-[10px]  <?php if ($step == 4): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-center text-[var(--color-blanc)] text-[30px] font-bold">3</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium">Votre politique de diversité</span>
    </div>
    <div class="item item-4 flex flex-row items-center justify-center gap-[10px]  <?php if ($step == 5 || $step == 6): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-center text-[var(--color-blanc)] text-[30px] font-bold">4</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium">Paiement</span>
    </div>
</div>