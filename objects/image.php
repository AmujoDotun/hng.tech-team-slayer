<?php 

class Image{


    public $id;
    public $user_id;
    public $image_file;

    public $extArray = ['jpg','jpeg','gif'];
    public $fopen;
    public $filePath ='../database/imageStorage.md';

    public function __construct($file_path)
    {
       $this->fopen =  fopen($file_path,'a');
    }

    public function create()
    {
        if(getImageSize($this->image_file['tmp_name']))
        {
            $checkifFileExists = file('../database/imageStorage.md');

            if(!empty($checkifFileExists))
            {
                
                $resultData = [];
                foreach($checkifFileExists as $fileExists)
                {
                    $resultData[] = json_decode($fileExists);
                }
                $FileName=$this->image_file['name'];
                if($this->toCheckIfImageAlreadyExists($resultData,$this->image_file['name']))
                {
                        $rand = str_shuffle(rand(10,10000000));
                        $imageArray = explode('.',$this->image_file['name']); 
                        $imgExt = end($imageArray);
                        $FileName = $imageArray[0].'-'.$rand.'.'.$imgExt;
                }

                if($this->toCheckIfItsCurrentUser($resultData,$this->user_id))
                {
                    $re_encodeData='';
                    $fopenNew = fopen($this->filePath,'w');
                    foreach ($resultData as $data)
                    {
                        if($data->user_id == $this->user_id)
                        {
                            if(unlink('../img/'.$data->profile_image))
                            {
                                if(move_uploaded_file($this->image_file['tmp_name'],'../img/'.$FileName))
                                {
                                    $re_encodeData= json_encode(['user_id'=>$this->user_id,'profile_image'=>$FileName]);
                            
                                    fwrite($fopenNew,"$re_encodeData\n");
                                }
                            }
                            
                        }else
                        {
                            $re_encodeData=json_encode($data);
                            fwrite($fopenNew,"$re_encodeData\n");
                        }
                        
                    }

                    return true;
                  
                }
                else
                {
                    $fopenNew = fopen($this->filePath,'w');
                    $re_encode=[];
                    foreach($resultData as $data)
                    {
                        $re_encode[] = json_encode($data);
                    }
                    
                    if(move_uploaded_file($this->image_file['tmp_name'],'../img/'.$FileName))
                    {
                        $notCurrentUser = json_encode(['user_id'=>$this->user_id,'profile_image'=>$FileName]);
                        $re_encode[] = $notCurrentUser;
                        
                        foreach ($re_encode as $encoded)
                        {
                            fwrite($fopenNew,"$encoded\n");
                        }
                        return true;
                    }
                }
            }
            else
            {
                if(move_uploaded_file($this->image_file['tmp_name'],'../img/'.$this->image_file['name']))
                {
                    
                    $imageFileStorage = ['user_id'=>$this->user_id,'profile_image'=>$this->image_file['name']];
                    
                    $jsonArray=json_encode($imageFileStorage);
                    
                    fwrite($this->fopen,"$jsonArray\n");

                    return true;
                }
            }
        }
        
    }

   public function toCheckIfImageAlreadyExists($fileArr,$imageName)
    {
    foreach ($fileArr as $key)
            {
                if($key->profile_image == $imageName )
                {
                    return true;
                }
            }
    }

    public function toCheckIfItsCurrentUser($data,$user_id)
    {
            foreach ($data as $user_data)
            {
                if($user_data->user_id == $user_id )
                {
                    return true;
                }
            }
    }

    


    
    
}
?>