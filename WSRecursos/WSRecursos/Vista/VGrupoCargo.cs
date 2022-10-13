using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VGrupoCargo : BDconexion
    {
        public List<EGrupoCargo> Listar_GrupoCargo()
        {
            List<EGrupoCargo> lCGrupoCargo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CGrupoCargo oVGrupoCargo = new CGrupoCargo();
                    lCGrupoCargo = oVGrupoCargo.Listar_GrupoCargo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCGrupoCargo);
        }
    }
}