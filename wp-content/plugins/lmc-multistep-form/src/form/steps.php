<div class="flex flex-row items-center justify-center gap-[40px] w-full py-[20px]">

    <div class="item item-1 flex flex-row items-center justify-center gap-[10px] <?php if ($step == 1): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-[var(--color-blanc)] text-[30px] font-bold flex justify-center items-center">1</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium hidden md:block">Organisation signataire</span>
    </div>
    <div class="item item-2 flex flex-row items-center justify-center gap-[10px]  <?php if ($step == 2 || $step == 3): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-[var(--color-blanc)] text-[30px] font-bold flex justify-center items-center">2</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium hidden md:block">Interlocuteurs</span>
    </div>
    <div class="item item-3 flex flex-row items-center justify-center gap-[10px]  <?php if ($step == 4): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-[var(--color-blanc)] text-[30px] font-bold flex justify-center items-center">3</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium hidden md:block">Votre politique de diversité</span>
    </div>
    <div class="item item-4 flex flex-row items-center justify-center gap-[10px]  <?php if ($step == 5 || $step == 6): ?>step-actif <?php endif; ?>">
        <span class="step-number block w-[40px] h-[40px] rounded-full bg-[var(--color-violet)] text-[var(--color-blanc)] text-[30px] font-bold flex justify-center items-center">4</span>
        <span class="step-title text-[var(--color-violet)] text-[18px] font-medium hidden md:block">Paiement</span>
    </div>
</div>