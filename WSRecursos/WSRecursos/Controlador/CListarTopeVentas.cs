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
    public class CListarTopeVentas
    {
        public List<EListarTopeVentas> ListarTopeVentas(SqlConnection con, String dni)
        {
            List<EListarTopeVentas> lEListarTopeVentas = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_VENTAS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarTopeVentas = new List<EListarTopeVentas>();

                EListarTopeVentas obEListarTopeVentas = null;
                while (drd.Read())
                {
                    obEListarTopeVentas = new EListarTopeVentas();
                    obEListarTopeVentas.cliente = drd["cliente"].ToString();
                    obEListarTopeVentas.periodo = drd["periodo"].ToString();
                    obEListarTopeVentas.total = drd["total"].ToString();
                    obEListarTopeVentas.tope_venta = drd["tope_venta"].ToString();
                    lEListarTopeVentas.Add(obEListarTopeVentas);
                }
                drd.Close();
            }

            return (lEListarTopeVentas);
        }
    }
}