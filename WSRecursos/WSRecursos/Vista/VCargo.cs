using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCargo : BDconexion
    {
        public List<ECargo> Cargo()
        {
            List<ECargo> lCCargo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCargo oVCargo = new CCargo();
                    lCCargo = oVCargo.Listar_Cargo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCargo);
        }
    }
}