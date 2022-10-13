using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VArea : BDconexion
    {
        public List<EArea> Area()
        {
            List<EArea> lCArea = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CArea oVArea = new CArea();
                    lCArea = oVArea.Listar_Area(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCArea);
        }
    }
}