using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCivil : BDconexion
    {
        public List<ECivil> Civil()
        {
            List<ECivil> lCCivil = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCivil oVCivil = new CCivil();
                    lCCivil = oVCivil.Listar_Civil(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCivil);
        }
    }
}