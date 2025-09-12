<?php
function renderForm(
    string $idSuffix = '',
    string $defaultValue = '',
    bool $readOnly = false
): void {
    $inputId = 'Jmeno' . htmlspecialchars($idSuffix, ENT_QUOTES, 'UTF-8');
    $value = htmlspecialchars($defaultValue, ENT_QUOTES, 'UTF-8');
    $readonlyAttr = $readOnly ? 'readonly class="bg-light text-dark"' : 'class="form-control"';
    $requiredAttr = $readOnly ? '' : 'required';
    echo '
    <div class="col-md-3">
        <label for="Jmeno" class="form-label pt-2">Jméno</label>
        <input ' . $readonlyAttr . ' class="form-control" type="text" name="Jmeno" id="Jmeno' . htmlspecialchars($idSuffix, ENT_QUOTES) . '"
            value="' . htmlspecialchars($defaultValue, ENT_QUOTES) . '" 
            placeholder="Jan" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Jan\'"
            onkeypress="return avoidspace(event)" ' . ($readOnly ? '' : 'required') . '>
        ' . ($readOnly ? '' : '<div class="invalid-feedback">Nevyplnili jste jméno</div>') . '
    </div>
    ';
}
