#include <string>
#include <vector>
#include <fstream>
#include <algorithm>

struct Man{
    std::string firstname, secondname;
    size_t age;
};

std::ostream& operator << (std::ostream& out, const Man& p){
    out << p.firstname << " " << p.secondname << " " << p.age;
    return out;
}

std::istream& operator >> (std::istream& in, Man& p){
    in >> p.firstname >> p.secondname >> p.age;
    return in;
}

struct comparator{
    comparator(){}
    bool operator ()(const Man& p1, const Man& p2){
        return p1.age < p2.age;
    }
};

struct Predicat{
    size_t begin, end;
    Predicat(int p1, int p2): begin(p1), end(p2) {}
    bool operator ()(const Man& p){
        return (p.age > begin) && (p.age < end);
    }
};

int main(){
    std::ifstream fin("input.txt");
    std::ofstream fout("output.txt");

    std::vector<Man> v;
    std::vector<Man>::iterator i;

    std::copy(std::istream_iterator<Man>(fin), 
        std::istream_iterator<Man>(),
        std::inserter(v, v.end()));
    std::sort(v.begin(), v.end(), comparator());

    i = std::find_if(v.begin(), v.end(), Predicat(20, 25));
    std::cout << (*i) << std::endl;

    std::copy(v.begin(), 
        v.end(), 
        std::ostream_iterator<Man>(fout, "\n"));
    return 0;
}
