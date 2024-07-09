<?php
/* @var $this PostsController */
/* @var $data Post */
?>

<div class="blog-post">
    <h2 class="post-title"><?php echo CHtml::encode($data->title); ?></h2>

    <div class="post-info">
        <span class="attribute-label"><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</span>
        <?php echo CHtml::encode($data->created_at); ?>
    </div>

    <div class="post-content">
        <?php echo CHtml::encode($data->content); ?>
    </div>

    <div class="post-meta">
        <span class="attribute-label"><?php echo 'Author'?>:</span>
        <?php echo CHtml::encode($data->user->username); ?>
    </div>
 <div class="post-meta">
        <span class="attribute-label"><?php echo CHtml::encode($data->getAttributeLabel('is_public')); ?>:</span>
        <?php echo CHtml::encode($data->is_public ? 'Public' : 'Private'); ?>
    </div>

    <div class="post-actions ">
        <!-- Optional: Add edit and delete links based on user permissions -->
        <?php if( isset(Yii::app()->user->id) && ( Yii::app()->user->id == $data->user_id) ): ?>
            <?php echo CHtml::link('Edit', array('update', 'id'=>$data->id)); ?>
            <?php echo CHtml::link('Delete', array('delete', 'id'=>$data->id), array('confirm'=>'Are you sure you want to delete this item?')); ?>
            <div class="post-meta">
                <span class="attribute-label"><?php echo CHtml::encode($data->getAttributeLabel('is_public')); ?>:</span>
                <?php echo CHtml::dropDownList(
                    'visibility',
                    $data->is_public,
                    array(1 => 'Public', 0 => 'Private'),
                    array(
                        'class' => 'visibility-dropdown',
                        'data-id' => $data->id
                    )
                ); ?>
            </div>
        <?php else:?>
            <?php echo CHtml::link('Like', array('posts/like', 'id'=>$data->id)); ?>
        <?php endif; ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Ensure that the event listener is attached only once
        $(document).off('change', '.visibility-dropdown').on('change', '.visibility-dropdown', function() {
            var postId = $(this).data('id');
            var visibility = $(this).val();

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl("posts/updateVisibility"); ?>',
                data: {
                    id: postId,
                    is_public: visibility,
            <?php echo Yii::app()->request->csrfTokenName; ?>: '<?php echo Yii::app()->request->csrfToken; ?>'
        },
            success: function(response) {
                alert('Visibility updated successfully');
            },
            error: function(xhr, status, error) {
                alert('Failed to update visibility');
            }
        });
        });
    });
</script>
