

<?php $__env->startSection('title', 'Editar Post'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Post</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('posts.update', $post)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label for="title" class="form-label">Título do Post</label>
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
                               value="<?php echo e(old('title', $post->title)); ?>"
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
                        <label for="category" class="form-label">Categoria</label>
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
                            <option value="">Selecione uma categoria</option>
                            <option value="Educação" <?php echo e((old('category', $post->category) == 'Educação') ? 'selected' : ''); ?>>Educação</option>
                            <option value="Saúde" <?php echo e((old('category', $post->category) == 'Saúde') ? 'selected' : ''); ?>>Saúde</option>
                            <option value="Meio Ambiente" <?php echo e((old('category', $post->category) == 'Meio Ambiente') ? 'selected' : ''); ?>>Meio Ambiente</option>
                            <option value="Direitos Humanos" <?php echo e((old('category', $post->category) == 'Direitos Humanos') ? 'selected' : ''); ?>>Direitos Humanos</option>
                            <option value="Animais" <?php echo e((old('category', $post->category) == 'Animais') ? 'selected' : ''); ?>>Animais</option>
                            <option value="Cultura" <?php echo e((old('category', $post->category) == 'Cultura') ? 'selected' : ''); ?>>Cultura</option>
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
                        <label for="content" class="form-label">Conteúdo</label>
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
                                  rows="6"
                                  required><?php echo e(old('content', $post->content)); ?></textarea>
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

                    <?php if($post->image): ?>
                        <div class="mb-3">
                            <label class="form-label">Imagem Atual</label>
                            <div>
                                <img src="<?php echo e(asset('storage/' . $post->image)); ?>" 
                                     class="img-fluid rounded mb-2" 
                                     style="max-height: 150px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                    <label class="form-check-label text-danger" for="remove_image">
                                        Remover imagem atual
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="image" class="form-label">Nova Imagem (opcional)</label>
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
                               accept="image/*">
                        <small class="text-muted">Deixe em branco para manter a imagem atual</small>
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
                    </div>

                    <div class="mb-3">
                        <div id="image-preview" class="mt-2" style="display: none;">
                            <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Atualizar Post
                        </button>
                        <a href="<?php echo e(route('posts.show', $post)); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const img = preview.querySelector('img');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ericl\Downloads\rede\rede\rede-social-ongs\resources\views/posts/edit.blade.php ENDPATH**/ ?>