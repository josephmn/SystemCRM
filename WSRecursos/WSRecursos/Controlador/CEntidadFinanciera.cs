using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CEntidadFinanciera
    {
        public List<EEntidadFinanciera> Listar_EntidadFinanciera(SqlConnection con)
        {
            List<EEntidadFinanciera> lEEntidadFinanciera = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_ENTIDADFINANCIERA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEEntidadFinanciera = new List<EEntidadFinanciera>();

                EEntidadFinanciera obEEntidadFinanciera = null;
                while (drd.Read())
                {
                    obEEntidadFinanciera = new EEntidadFinanciera();
                    obEEntidadFinanciera.i_id = drd["i_id"].ToString();
                    obEEntidadFinanciera.v_descripcion = drd["v_descripcion"].ToString();
                    obEEntidadFinanciera.v_default = drd["v_default"].ToString();
                    lEEntidadFinanciera.Add(obEEntidadFinanciera);
                }
                drd.Close();
            }

            return (lEEntidadFinanciera);
        }
    }
}