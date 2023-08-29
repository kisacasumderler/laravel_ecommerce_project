<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'name'=>'Moda Trendlerinde Yön Veren UtkuShop: Alışverişinizi Şıklaştırın!',
            'content'=>'
            <p>UtkuShop, 2023 yılında kurulan yenilikçi bir online alışveriş platformudur. Amacımız, müşterilerimize modanın en yeni ve şık ürünlerini sunarak alışveriş deneyimlerini en üst düzeyde geliştirmektir. Ayakkabı, saat ve aksesuar gibi moda ürünlerinin geniş bir yelpazesine sahibiz.</p>

            <h3>Müşteri Memnuniyeti Bizim Önceliğimiz</h3>

            <p>UtkuShop olarak, müşteri memnuniyetini her şeyin önünde tutuyoruz. Müşterilerimizin beklentilerini karşılamak ve aşmak için sürekli olarak çalışıyoruz. Ürünlerimizi özenle seçiyor ve müşterilerimize sunuyoruz. Her bir ürünümüz, kalite, stil ve işlevsellik açısından titizlikle değerlendirildiğinden, müşterilerimiz yalnızca en iyisini bulacaklarından emin olabilirler.</p>

            <h3>Geniş Ürün Yelpazesi</h3>

            <p>UtkuShop olarak, moda dünyasının en son trendlerini takip ediyoruz ve geniş bir ürün yelpazesi sunuyoruz. Ayakkabılarımız farklı stiller ve renklerle tarzınızı tamamlarken, saatlerimiz hassas işçilik ve yenilikçi tasarımlarla dikkat çekiyor. Takı ve aksesuarlarımız ise kişisel tarzınızı yansıtan özgün parçalar sunuyor. Müşterilerimiz için çeşitli seçenekler sunarak her zevke hitap etmeyi amaçlıyoruz.</p>

            <h3>Güvenilirlik ve Hızlı Teslimat</h3>

            <p>UtkuShop olarak, müşterilerimize güvenilir bir alışveriş deneyimi sunmaya önem veriyoruz. Siparişlerin hızlı bir şekilde işlenmesi ve zamanında teslimatı için çaba sarf ediyoruz. Aynı zamanda güvenilir ödeme seçenekleri sunarak müşterilerimizin alışverişlerini güvenle tamamlamalarını sağlıyoruz.</p>

            <h3>Müşteri Desteği</h3>

            <p>UtkuShop, müşteri memnuniyetini sağlamak için deneyimli bir müşteri destek ekibiyle birlikte çalışır. Sorularınızı yanıtlamak, yardımcı olmak ve herhangi bir sorunuz olduğunda çözüm bulmak için her zaman buradayız. Müşterilerimize en iyi alışveriş deneyimini sunmak için sürekli çaba gösteriyoruz.</p>
            ',
            'text_1'=>'BUGÜN TESLIMAT',
            'text_1_icon'=>'icon-truck',
            'text_1_content'=>'Saat 14:00\'a kadar verdiğiniz sipaişler aynı gün kapınızda.',
            'text_2'=>'KOLAY IADE',
            'text_2_icon'=>'icon-refresh2',
            'text_2_content'=>'Aldığınız herhangi bir ürünü 14 gün içerisinde kolaylıkla iade edebilirsiniz.',
            'text_3'=>'MÜŞTERI DESTEĞI',
            'text_3_icon'=>'icon-help',
            'text_3_content'=>'7/24 web sitemiz/mobil uygulamamız ve müşteri çözüm merkezimizden sorularınızla ilgili destek alabilirsiniz.',
        ]);
    }
}
