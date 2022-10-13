using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHeadcountCargo : BDconexion
    {
        public List<EIndHeadcountCargo> Listar_IndHeadcountCargo()
        {
            List<EIndHeadcountCargo> lCIndHeadcountCargo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHeadcountCargo oVIndHeadcountCargo = new CIndHeadcountCargo();
                    lCIndHeadcountCargo = oVIndHeadcountCargo.Listar_IndHeadcountCargo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHeadcountCargo);
        }
    }
}