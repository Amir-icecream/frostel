<?php 
namespace Core;

use Exception;

class View{
    protected $patterns;
    protected $file;
    protected $temp_file;

    public function __construct() {
        $this->patterns = [
            '/@php\s(.*?)@endphp/s'  => '<?php $1 ?>',
            '/@echo\s+(.*)/' => '<?php echo($1); ?>',
            '/{{\s*(.*?)\s*}}/'      => '<?php echo(htmlspecialchars($1,ENT_QUOTES,"UTF-8")); ?>',
            '/{{!!\s*(.*?)\s*!!}}/'    => '<?php echo($1); ?>',
            '/@if\s*\((.*?)\)/'      => '<?php if($1): ?>',
            '/@endif/'               => '<?php endif; ?>',
            '/@foreach\s*\((.*?)\)/' => '<?php foreach($1): ?>',
            '/@endforeach/'          => '<?php endforeach; ?>',
            '/@csrf/'          => '<input name="X_CSRF_TOKEN" value="<?php echo(csrf_token()); ?>" id="csrf-token" hidden>',
        ];
    }

    public function compile($view){
        $this->file = file_get_contents(__DIR__ . "/../resource/view/$view.blade.php");
        $this->temp_file = __DIR__ . "/../storage/framework/view/$view.php";
        if(file_exists($this->temp_file) and $_ENV['CACHE'] === 'true')
        {
            return($this->temp_file);
        }

        foreach ($this->patterns as $pattern => $replace) {
            $this->file = preg_replace($pattern,$replace,$this->file);
        }

        file_put_contents($this->temp_file,$this->file);
        return($this->temp_file);
    }
    public function render($view,$values = null){
        if(!file_exists(__DIR__ . "/../resource/view/$view.blade.php"))
        {
            throw new Exception("view: $view not found");
        }
        if(is_array($values))
        {
            extract($values);
        }
        return require_once($this->compile($view));
    }
}

