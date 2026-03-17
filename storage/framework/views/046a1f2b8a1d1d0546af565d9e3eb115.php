

<?php $__env->startSection('title', 'Criar Novo Post'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Criar Novo Post</h4>
            </div>

            <div class="card-body">
                
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('posts.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Título do Post</label>
                        <input type="text"
                               class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="title"
                               name="title"
                               value="<?php echo e(old('title')); ?>"
                               placeholder="Digite um título impactante"
                               required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold">Categoria</label>
                        <select class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="category"
                                name="category">
                            <option value="" selected>Selecione uma categoria (opcional)</option>
                            <option value="Educação" <?php echo e(old('category') == 'Educação' ? 'selected' : ''); ?>>Educação</option>
                            <option value="Saúde" <?php echo e(old('category') == 'Saúde' ? 'selected' : ''); ?>>Saúde</option>
                            <option value="Meio Ambiente" <?php echo e(old('category') == 'Meio Ambiente' ? 'selected' : ''); ?>>Meio Ambiente</option>
                            <option value="Direitos Humanos" <?php echo e(old('category') == 'Direitos Humanos' ? 'selected' : ''); ?>>Direitos Humanos</option>
                            <option value="Animais" <?php echo e(old('category') == 'Animais' ? 'selected' : ''); ?>>Animais</option>
                            <option value="Cultura" <?php echo e(old('category') == 'Cultura' ? 'selected' : ''); ?>>Cultura</option>
                            <option value="Assistência Social" <?php echo e(old('category') == 'Assistência Social' ? 'selected' : ''); ?>>Assistência Social</option>
                        </select>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Conteúdo</label>
                        <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="content"
                                  name="content"
                                  rows="8"
                                  placeholder="Escreva aqui o conteúdo do seu post..."
                                  required><?php echo e(old('content')); ?></textarea>
                        <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Imagem de destaque (opcional)</label>
                        <input type="file"
                               class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="image"
                               name="image"
                               accept="image/png, image/jpeg, image/jpg, image/gif">
                        <small class="text-muted">Formatos aceitos: JPG, JPEG, PNG, GIF. Máximo: 2MB</small>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        
                        <div id="image-preview" class="mt-3 text-center" style="display: none;">
                            <img src="#" alt="Preview da imagem"
                                 class="img-fluid rounded border"
                                 style="max-height: 200px;">
                        </div>
                    </div>

                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('ong.dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Publicar Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Preview da imagem antes do upload
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const img = preview.querySelector('img');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Validação simples de tamanho de imagem
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            alert('A imagem não pode ter mais que 2MB.');
            this.value = '';
            document.getElementById('image-preview').style.display = 'none';
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/posts/create.blade.php ENDPATH**/ ?>